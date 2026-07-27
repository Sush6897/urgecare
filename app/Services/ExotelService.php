<?php

namespace App\Services;

use App\Models\CallLog;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;


class ExotelService
{
    private const LOG_CHANNEL = 'exotel';

    /** Terminal outcomes that stop the current leg (Exotel normalizes case in our resolver). */
    private const TERMINAL_SUCCESS = ['completed'];

    private const TERMINAL_FAILURE = [
        'busy',
        'no-answer',
        'failed',
        'canceled',
        'cancelled',
        'rejected',      // callee declined / reject button (Exotel)
        'declined',
        'missed',
        'timeout',
        'unavailable',
    ];

    /** Intermediate — do not advance sequence. */
    private const NON_TERMINAL = ['queued', 'ringing', 'in-progress', 'initiated', ''];

    public function __construct(
        protected ?string $accountSid = null,
        protected ?string $apiKey = null,
        protected ?string $apiToken = null,
        protected ?string $callerId = null,
    ) {
        $this->accountSid = $accountSid ?: (string) config('services.exotel.account_sid');
        $this->apiKey = $apiKey ?: (string) config('services.exotel.api_key');
        $this->apiToken = $apiToken ?: (string) config('services.exotel.api_token');
        $this->callerId = $callerId ?: (string) config('services.exotel.caller_id');
    }

    /**
     * Create a call log row and place the first outbound leg.
     *
     * @param  list<string>  $numbers
     */
    public function createLogAndStartDial(
        string $from,
        array $numbers,
        ?string $patientName = null,
        ?int $hospitalId = null,
        ?string $latitude = null,
        ?string $longitude = null
    ): CallLog {
        $numbers = array_values(array_unique(array_filter(array_map('trim', $numbers))));
        if ($numbers === []) {
            throw new \InvalidArgumentException('At least one destination number is required.');
        }

        $from = $this->normalizePhone($from);
        $callLog = CallLog::create([
            'from_number' => $from,
            'numbers' => $numbers,
            'current_index' => 0,
            'status' => CallLog::STATUS_IN_PROGRESS,
            'attempts' => [],
            'patient_name' => $patientName,
            'hospital_id' => $hospitalId,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        $sid = $this->placeCall($callLog, 0);
        if ($sid) {
            $callLog->update(['call_sid' => $sid]);
        }

        return $callLog->fresh();
    }

    /**
     * Place Exotel connect for the number at the given index.
     */
    public function placeCall(CallLog $callLog, int $index): ?string
    {
        $numbers = $callLog->numbers;
        if (! isset($numbers[$index])) {
            return null;
        }

        $result = $this->connect($callLog->from_number, $numbers[$index], $callLog->id);
        if (! $result['ok']) {
            $this->exotelLog()->error('Exotel connect failed', ['call_log_id' => $callLog->id, 'error' => $result['error'] ?? null]);

            return null;
        }

        return $result['call_sid'] ?? null;
    }

    /**
     * @return array{ok: bool, call_sid?: string, error?: string, raw?: mixed}
     */
    public function connect(string $from, string $to, int $callLogId): array
    {
        if ($this->accountSid === '' || $this->apiKey === '' || $this->apiToken === '' || $this->callerId === '') {
            return ['ok' => false, 'error' => 'Exotel is not configured (check EXOTEL_* env keys).'];
        }

        $url = "https://api.exotel.com/v1/Accounts/{$this->accountSid}/Calls/connect.json";

        $payload = [
            'From' => $from,
            'To' => $to,
            'CallerId' => $this->callerId,
            'StatusCallback' => route('exotel.callback'),
            'CustomField' => (string) $callLogId,
            'Record' => 'true',
            'RecordingChannels' => 'single',
            'RecordingFormat' => 'mp3',
        ];

        // Without this, Exotel often omits Legs[] / leg Status — failover logic never sees reject/no-answer.
        $events = (string) config('services.exotel.status_callback_events', 'terminal');
        if ($events !== '') {
            $payload['StatusCallbackEvents[0]'] = $events;
        }

        $contentType = (string) config('services.exotel.status_callback_content_type', '');
        if ($contentType !== '') {
            $payload['StatusCallbackContentType'] = $contentType;
        }

        $response = Http::withBasicAuth($this->apiKey, $this->apiToken)
            ->asForm()
            ->post($url, $payload);

        if ($response->failed()) {
            return ['ok' => false, 'error' => $response->body(), 'raw' => $response->json()];
        }

        $data = $response->json();
        $sid = $data['Call']['Sid'] ?? null;

        return ['ok' => true, 'call_sid' => $sid, 'raw' => $data];
    }

    public function handleCallback(Request $request): void
    {
        $this->exotelLog()->info('Exotel callback', $request->all());

        $callLogId = $request->input('CustomField');
        $callSid = $request->input('CallSid')
            ?? $request->input('Sid')
            ?? $request->input('DialCallSid');

        $callLog = null;
        $resolvedViaCustomField = false;
        if ($callLogId !== null && $callLogId !== '') {
            $callLog = CallLog::find((int) $callLogId);
            $resolvedViaCustomField = $callLog !== null;
        }
        if (! $callLog && $callSid) {
            $callLog = CallLog::where('call_sid', $callSid)->first();
        }

        if (! $callLog) {
            $this->exotelLog()->warning('Exotel callback: CallLog not found', $request->all());

            return;
        }

        if (in_array($callLog->status, [CallLog::STATUS_COMPLETED, CallLog::STATUS_EXHAUSTED], true)) {
            return;
        }

        $status = $this->resolveStatus($request);
        if ($status === null || $status === '') {
            $this->exotelLog()->info('Exotel callback: no status yet', $request->all());

            return;
        }

        // Exotel sometimes sends a leg/parent Sid that differs from connect.json — trust CustomField when present.
        if (
            ! $resolvedViaCustomField
            && $callSid
            && $callLog->call_sid
            && $callSid !== $callLog->call_sid
        ) {
            $this->exotelLog()->info('Exotel callback: ignoring stale CallSid', [
                'call_log_id' => $callLog->id,
                'expected' => $callLog->call_sid,
                'got' => $callSid,
            ]);

            return;
        }

        if ($this->isNonTerminal($status)) {
            $callLog->update(['last_exotel_status' => $status]);

            if ($status === 'in-progress') {
                $this->recordEnquiry($callLog, $callSid, 'initiated');
            }

            return;
        }

        if (! $this->isTerminal($status)) {
            $callLog->update(['last_exotel_status' => $status]);

            return;
        }

        $this->processTerminalStatus($callLog, $status, $callSid);
    }

    public function resolveStatus(Request $request): ?string
    {
        // Multi-leg outbound: Legs[0] is often the From leg (completed), Legs[1+] the To/hospital leg.
        // Prefer deriving from Legs when more than one leg so we never treat the caller leg as the outcome.
        $legs = $request->input('Legs');
        if (is_array($legs) && count($legs) > 1) {
            $fromLegs = $this->resolveStatusFromLegs($legs);
            if ($fromLegs !== null) {
                return $fromLegs;
            }
        }

        $candidates = [
            $request->input('DialCallStatus'),
            $request->input('Status'),
            $request->input('CallStatus'),
            $request->input('DialWhomLegStatus'),
        ];

        foreach ($candidates as $s) {
            if (is_string($s) && trim($s) !== '') {
                return strtolower(trim($s));
            }
        }

        if (is_array($legs) && $legs !== []) {
            return $this->resolveStatusFromLegs($legs);
        }

        return null;
    }

    /**
     * Prefer hospital/destination leg: last leg with Status, or any leg with a failure status.
     *
     * @param  mixed  $legs
     */
    private function resolveStatusFromLegs($legs): ?string
    {
        if (! is_array($legs) || $legs === []) {
            return null;
        }

        foreach ($legs as $leg) {
            if (! is_array($leg)) {
                continue;
            }
            $st = isset($leg['Status']) ? strtolower(trim((string) $leg['Status'])) : '';
            if ($st !== '' && in_array($st, self::TERMINAL_FAILURE, true)) {
                return $st;
            }
        }

        for ($i = count($legs) - 1; $i >= 0; $i--) {
            $leg = $legs[$i];
            if (! is_array($leg)) {
                continue;
            }
            $st = isset($leg['Status']) ? strtolower(trim((string) $leg['Status'])) : '';
            if ($st !== '') {
                return $st;
            }
        }

        return null;
    }

    private function processTerminalStatus(CallLog $callLog, string $status, ?string $callSid): void
    {
        $numbers = $callLog->numbers;
        $idx = $callLog->current_index;
        $dialedTo = $numbers[$idx] ?? null;

        $attempts = $callLog->attempts ?? [];
        $attempts[] = [
            'at' => now()->toIso8601String(),
            'to' => $dialedTo,
            'call_sid' => $callSid,
            'exotel_status' => $status,
        ];

        if (in_array($status, self::TERMINAL_SUCCESS, true)) {
            $callLog->update([
                'status' => CallLog::STATUS_COMPLETED,
                'last_exotel_status' => $status,
                'attempts' => $attempts,
            ]);

            $this->recordEnquiry($callLog, $callSid, 'completed');

            // Send all 3 post-call SMS notifications
            $this->sendPostCallPatientSms($callLog);
            $this->sendPostCallUrgecareAdminSms($callLog);
            $this->sendPostCallAmbulanceProviderSms($callLog, $dialedTo);

            return;
        }

        if (! in_array($status, self::TERMINAL_FAILURE, true)) {
            $callLog->update([
                'last_exotel_status' => $status,
                'attempts' => $attempts,
            ]);

            return;
        }

        $nextIndex = $idx + 1;
        if (isset($numbers[$nextIndex])) {
            $this->exotelLog()->info('Exotel failover: dialing next number', [
                'call_log_id' => $callLog->id,
                'from_index' => $idx,
                'to_index' => $nextIndex,
                'failed_status' => $status,
                'next_to' => $numbers[$nextIndex],
            ]);

            $callLog->update([
                'current_index' => $nextIndex,
                'last_exotel_status' => $status,
                'attempts' => $attempts,
            ]);

            $model = $callLog->fresh();
            $newSid = $this->placeCall($model, $nextIndex);
            if ($newSid) {
                $model->update(['call_sid' => $newSid]);
            } else {
                $model->update([
                    'status' => CallLog::STATUS_EXHAUSTED,
                    'last_exotel_status' => 'connect_failed',
                ]);
            }

            return;
        }

        $callLog->update([
            'status' => CallLog::STATUS_EXHAUSTED,
            'last_exotel_status' => $status,
            'attempts' => $attempts,
        ]);

        // Send post-call SMS notifications on call exhaustion/failure as well
        $this->sendPostCallPatientSms($callLog);
        $this->sendPostCallUrgecareAdminSms($callLog);
        $this->sendPostCallAmbulanceProviderSms($callLog, $dialedTo ?? ($numbers[0] ?? '917888021021'));
    }

    private function isNonTerminal(string $status): bool
    {
        return in_array($status, self::NON_TERMINAL, true);
    }

    private function isTerminal(string $status): bool
    {
        return in_array($status, array_merge(self::TERMINAL_SUCCESS, self::TERMINAL_FAILURE), true);
    }

    private function normalizePhone(string $value): string
    {
        return preg_replace('/\s+/', '', $value) ?? $value;
    }

    private function recordEnquiry(CallLog $callLog, ?string $callSid, string $status = 'initiated'): void
    {
        if (! $callSid) {
            return;
        }

        $enquiry = DB::table('enquiries')->where('sid', $callSid)->first();

        if (! $enquiry) {
            $targetNumber = $callLog->numbers[$callLog->current_index] ?? ($callLog->numbers[0] ?? '');

            DB::table('enquiries')->insert([
                'patient_name' => $callLog->patient_name,
                'hospital_id' => $callLog->hospital_id,
                'sid' => $callSid,
                'from' => $callLog->from_number,
                'to' => $targetNumber,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->exotelLog()->info("Enquiry recorded as {$status}", [
                'call_log_id' => $callLog->id,
                'call_sid' => $callSid,
            ]);
        } elseif ($status === 'completed' && $enquiry->status !== 'completed') {
            DB::table('enquiries')->where('sid', $callSid)->update([
                'status' => 'completed',
                'updated_at' => now(),
            ]);

            $this->exotelLog()->info('Enquiry updated to completed', [
                'call_sid' => $callSid,
            ]);
        }
    }

    /**
     * Send SMS via Exotel SMS API and log into storage/logs/sms.log & exotel.log.
     *
     * @return array{ok: bool, response?: mixed, error?: string}
     */
    public function sendSms(
        string $to,
        string $templateId,
        string $header,
        string $body,
        ?string $messageType = null,
        ?int $callLogId = null
    ): array {
        if ($this->accountSid === '' || $this->apiKey === '' || $this->apiToken === '') {
            $err = 'Exotel SMS credentials not configured.';
            $this->smsLog()->error($err, compact('to', 'templateId', 'header', 'messageType', 'callLogId'));

            return ['ok' => false, 'error' => $err];
        }

        $cleanTo = ltrim(preg_replace('/\D/', '', $to), '0');
        if (strlen($cleanTo) === 10) {
            $cleanTo = $cleanTo;
        }

        $url = "https://api.exotel.com/v1/Accounts/{$this->accountSid}/Sms/send.json";

        $payload = [
            'From' => $header,
            'To' => $cleanTo,
            'Body' => $body,
            'DltTemplateId' => $templateId,
            'DltEntityId' => '1701164398108412688',
            'SmsType' => 'transactional',
        ];

        try {
            $response = Http::withBasicAuth($this->apiKey, $this->apiToken)
                ->asForm()
                ->post($url, $payload);

            $responseData = $response->json();
            $isSuccess = $response->successful();

            $logData = [
                'call_log_id' => $callLogId,
                'message_type' => $messageType,
                'header' => $header,
                'template_id' => $templateId,
                'to' => $cleanTo,
                'body' => $body,
                'status' => $isSuccess ? 'SUCCESS' : 'FAILED',
                'http_code' => $response->status(),
                'response' => $responseData ?? $response->body(),
                'timestamp' => now()->toIso8601String(),
            ];

            if ($isSuccess) {
                $this->smsLog()->info("SMS Sent [{$messageType}] to {$cleanTo}", $logData);
                $this->exotelLog()->info("SMS Sent [{$messageType}] to {$cleanTo}", $logData);

                return ['ok' => true, 'response' => $responseData];
            } else {
                $this->smsLog()->error("SMS Failed [{$messageType}] to {$cleanTo}", $logData);
                $this->exotelLog()->error("SMS Failed [{$messageType}] to {$cleanTo}", $logData);

                return ['ok' => false, 'error' => $response->body(), 'response' => $responseData];
            }
        } catch (\Exception $e) {
            $logData = [
                'call_log_id' => $callLogId,
                'message_type' => $messageType,
                'header' => $header,
                'template_id' => $templateId,
                'to' => $cleanTo,
                'body' => $body,
                'status' => 'EXCEPTION',
                'error' => $e->getMessage(),
                'timestamp' => now()->toIso8601String(),
            ];

            $this->smsLog()->error("SMS Exception [{$messageType}] to {$cleanTo}: " . $e->getMessage(), $logData);
            $this->exotelLog()->error("SMS Exception [{$messageType}] to {$cleanTo}: " . $e->getMessage(), $logData);

            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Message 1: Message to URGECARE- TO ME (Template Id: 1707177364516989149, Header: URGKER)
     * DLT Pattern: You just spoke with {#var#}{#var#}for{#var#} ambulance help .for more assistance call Team Urge care {#var#}
     * 1st var - Name
     * 2nd var - Number (patient)
     * 3rd var - Hospital name
     * 4th var - 8788934087
     */
    public function sendPostCallUrgecareAdminSms(CallLog $callLog): void
    {
        $var1 = $callLog->patient_name ? trim($callLog->patient_name) . ' ' : '';
        $var2 = trim($callLog->from_number) . ' ';
        $hospital = Hospital::find($callLog->hospital_id);
        $hospitalName = $hospital ? $hospital->hospital_name : 'Hospital';
        $var3 = ' ' . trim($hospitalName);
        $var4 = '8788934087';

        $body = "You just spoke with {$var1}{$var2}for{$var3} ambulance help .for more assistance call Team Urge care {$var4}";

        $adminNumbers = ['8788934087', '7888021021'];
        foreach ($adminNumbers as $number) {
            $this->sendSms(
                $number,
                '1707177364516989149',
                'URGKER',
                $body,
                'URGECARE_ADMIN_POST_CALL',
                $callLog->id
            );
        }
    }

    /**
     * Message 2: Message to Patient (Template Id: 1707177738048468288, Header: URGKER)
     * DLT Pattern: Thanks for Contacting Urgecare Ambulance Services.Pls share your location on whats app No. {#var#} for further assitance .Team Urgecare ,Helpline No .{#var#}{#var#}
     * 1st var - 7888021021
     * 2nd var - 7888021021
     * 3rd var - https://urgecare.in/
     */
    public function sendPostCallPatientSms(CallLog $callLog): void
    {
        if (! $callLog->from_number) {
            return;
        }

        $var1 = '7888021021';
        $var2 = '7888021021 ';
        $var3 = 'https://urgecare.in/';

        $body = "Thanks for Contacting Urgecare Ambulance Services.Pls share your location on whats app No. {$var1} for further assitance .Team Urgecare ,Helpline No .{$var2}{$var3}";

        $this->sendSms(
            $callLog->from_number,
            '1707177738048468288',
            'URGKER',
            $body,
            'PATIENT_POST_CALL',
            $callLog->id
        );
    }

    /**
     * Message 3: Message to call receiver - Ambulance service Provider (Template Id: 1707168475359519031, Header: URGKER)
     * DLT Pattern: You just spoke with {#var#} for ambulance help. For more assistance call {#var#} Team –Urgecare
     * 1st var - Patient number
     * 2nd var - Patient Location (includes Google Maps URL if lat/lng available)
     */
    public function sendPostCallAmbulanceProviderSms(CallLog $callLog, ?string $to): void
    {
        if (! $to) {
            return;
        }

        $patientNumber = trim($callLog->from_number);
        $hospital = Hospital::find($callLog->hospital_id);
        $locationText = $hospital ? ($hospital->area ?: $hospital->city) : '';

        if ($callLog->latitude && $callLog->longitude) {
            $googleMapsUrl = "https://maps.google.com/?q={$callLog->latitude},{$callLog->longitude}";
            $patientLocation = $locationText ? "{$locationText} {$googleMapsUrl}" : $googleMapsUrl;
        } else {
            $patientLocation = $locationText ?: '7888021021';
        }

        $body = "You just spoke with {$patientNumber} for ambulance help. For more assistance call {$patientLocation} Team –Urgecare";

        $this->sendSms(
            $to,
            '1707168475359519031',
            'URGKER',
            $body,
            'PROVIDER_POST_CALL',
            $callLog->id
        );
    }

    private function smsLog(): LoggerInterface
    {
        return Log::channel('sms');
    }

    private function exotelLog(): LoggerInterface
    {
        return Log::channel(self::LOG_CHANNEL);
    }
}
