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
        protected ?string $accountSid = 'uc1641',
        protected ?string $apiKey = "9ecda612ebfeb89f36a712e6c39b769075e739004bb18092",
        protected ?string $apiToken = "3a2d575d67a561f0ffe8aa5e62e5f9aecf8117adb5009a7e",
        protected ?string $callerId = "02048556108",
    ) {
        $this->accountSid = $accountSid ?? (string) config('services.exotel.account_sid');
        $this->apiKey = $apiKey ?? (string) config('services.exotel.api_key');
        $this->apiToken = $apiToken ?? (string) config('services.exotel.api_token');
        $this->callerId = $callerId ?? (string) config('services.exotel.caller_id');
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
        ?int $hospitalId = null
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
        ]);

        $sid = $this->placeCall($callLog, 0);
        if ($sid) {
            $callLog->update(['call_sid' => $sid]);
        }

        return $callLog->fresh();
    }

    /**
     * Place Exotel connect for all numbers (parallel ringing).
     */
    // public function placeCall(CallLog $callLog): ?string
    // {
    //     $numbers = array_map([$this, 'normalizePhone'], $callLog->numbers);
    //     if (empty($numbers)) {
    //         return null;
    //     }

    //     $result = $this->connect($callLog->from_number, $numbers, $callLog->id);
    //     if (! $result['ok']) {
    //         $this->exotelLog()->error('Exotel parallel connect failed', [
    //             'call_log_id' => $callLog->id,
    //             'error' => $result['error'] ?? null
    //         ]);

    //         return null;
    //     }

    //     return $result['call_sid'] ?? null;
    // }
    public function placeCall(CallLog $callLog): ?string
    {
        $numbers = array_map([$this, 'normalizePhone'], $callLog->numbers);
        if (empty($numbers)) {
            return null;
        }

        $result = $this->connect($callLog->from_number, $numbers, $callLog->id);
        if (! $result['ok']) {
            $this->exotelLog()->error('Exotel parallel connect failed', [
                'call_log_id' => $callLog->id,
                'error' => $result['error'] ?? null
            ]);

            return null;
        }

        return $result['call_sid'] ?? null;
    }
    /**
     * @return array{ok: bool, call_sid?: string, error?: string, raw?: mixed}
     */
    public function connect(string $from, array $to, int $callLogId): array
    {
        if ($this->accountSid === '' || $this->apiKey === '' || $this->apiToken === '' || $this->callerId === '') {
            return ['ok' => false, 'error' => 'Exotel is not configured.'];
        }

        $url = "https://api.exotel.com/v1/Accounts/{$this->accountSid}/Calls.json";
        $flowUrl = route('exotel.flow', ['CustomField' => $callLogId]);

        $payload = [
            'From' => $from, // Dial patient first
            'To' => $this->callerId, // Required but overridden by Url
            'CallerId' => $this->callerId,
            'Url' => $flowUrl,
            'StatusCallback' => route('exotel.callback'),
            'CustomField' => (string) $callLogId,
            'Record' => 'true',
        ];

        $this->exotelLog()->info("Initiating parallel call flow", [
            'patient' => $from,
            'hospital_count' => count($to),
            'flow_url' => $flowUrl
        ]);

        $response = Http::withBasicAuth($this->apiKey, $this->apiToken)
            ->asForm()
            ->post($url, $payload);

        if ($response->successful()) {
            $sid = $response->json()['Call']['Sid'] ?? null;
            return ['ok' => true, 'call_sid' => $sid];
        } else {
            return ['ok' => false, 'error' => $response->body()];
        }
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
        $dialedTo = implode(',', $numbers);

        $attempts = $callLog->attempts ?? [];
        $attempts[] = [
            'to' => $dialedTo,
            'call_sid' => $callSid,
            'exotel_status' => $status,
            'type' => 'parallel',
        ];

        if (in_array($status, self::TERMINAL_SUCCESS, true)) {
            $callLog->update([
                'status' => CallLog::STATUS_COMPLETED,
                'last_exotel_status' => $status,
                'attempts' => $attempts,
            ]);

            $this->recordEnquiry($callLog, $callSid, 'completed');

            $answeredBy = request()->input('DialWhomNumber') ?? ($numbers[0] ?? null);
            $this->sendPostCallSms($callLog, $answeredBy);

            return;
        }

        $callLog->update([
            'status' => CallLog::STATUS_EXHAUSTED,
            'last_exotel_status' => $status,
            'attempts' => $attempts,
        ]);

        $this->sendPostCallSms($callLog, '917888021021');
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
        return preg_replace('/\D/', '', $value) ?? $value;
    }

    private function recordEnquiry(CallLog $callLog, ?string $callSid, string $status = 'initiated'): void
    {
        if (! $callSid) {
            return;
        }

        $enquiry = DB::table('enquiries')->where('sid', $callSid)->first();

        if (! $enquiry) {
            $targetNumber = request()->input('DialWhomNumber') 
                ?? ($callLog->numbers[0] ?? '');

            DB::table('enquiries')->insert([
                'patient_name' => $callLog->patient_name,
                'from' => $callLog->from_number,
                'hospital_id' => $callLog->hospital_id,
                'to' => $targetNumber,
                'sid' => $callSid,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::channel('exotel')->info('Enquiry recorded', [
                'patient' => $callLog->patient_name,
                'call_sid' => $callSid,
            ]);
        } elseif ($status === 'completed' && $enquiry->status !== 'completed') {
            DB::table('enquiries')->where('sid', $callSid)->update([
                'status' => 'completed',
                'to' => request()->input('DialWhomNumber') ?? $enquiry->to,
                'updated_at' => now(),
            ]);

            Log::channel('exotel')->info('Enquiry marked as completed', [
                'call_sid' => $callSid,
                'answered_by' => request()->input('DialWhomNumber')
            ]);
        }
    }

    private function sendPostCallSms(CallLog $callLog, ?string $to): void
    {
        if (!$to) {
            return;
        }

        $hospital = Hospital::find($callLog->hospital_id);
        $hospitalName = $hospital ? $hospital->hospital_name : 'Hospital';
        $patientName = $callLog->patient_name ?? 'Patient';
        $patientContact = $callLog->from_number ?? '';
        $helpline = '8149801662';

        // Normalize phone number for SMS
        $cleanTo = ltrim(preg_replace('/\D/', '', $to), '0');
        if (strlen($cleanTo) === 10) {
            $cleanTo = '91' . $cleanTo;
        }

        $body = "You just spoke with {$patientName} {$patientContact} for {$hospitalName} ambulance help. For more assistance call Team Urge Care {$helpline}";

        try {
            $url = "https://api.exotel.com/v1/Accounts/{$this->accountSid}/Sms/send.json";

            $response = Http::withBasicAuth($this->apiKey, $this->apiToken)
                ->asForm()
                ->post($url, [
                    'From' => 'URGKER',
                    'To' => $cleanTo,
                    'Body' => $body,
                    'DltTemplateId' => '1707177364516989149',
                    'DltEntityId' => '1701164398108412688',
                    'SmsType' => 'transactional',
                ]);

            if ($response->successful()) {
                $this->exotelLog()->info("Post-call SMS sent to {$cleanTo}", [
                    'call_log_id' => $callLog->id,
                    'response' => $response->json()
                ]);
            } else {
                $this->exotelLog()->error("Failed to send post-call SMS to {$cleanTo}", [
                    'call_log_id' => $callLog->id,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            $this->exotelLog()->error("Post-call SMS Exception: " . $e->getMessage(), [
                'call_log_id' => $callLog->id
            ]);
        }
    }

    private function exotelLog(): LoggerInterface
    {
        return Log::channel(self::LOG_CHANNEL);
    }
}
