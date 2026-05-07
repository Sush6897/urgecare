<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExotelFlowController extends Controller
{
   public function handle(Request $request)
    {
        Log::channel('exotel')->info('Exotel Flow Endpoint Hit', [
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'all_input' => $request->all()
        ]);

        $callLogId = $request->input('CustomField');

        if (!$callLogId) {
            return $this->errorResponse('Missing Call Log ID');
        }

        $callLog = CallLog::find($callLogId);
        if (!$callLog) {
            return $this->errorResponse('Call Log Not Found');
        }

        $numbers = $callLog->numbers;

        if (empty($numbers)) {
            return $this->errorResponse('No numbers found');
        }

        $normalizedNumbers = array_map(function ($num) {
            $num = preg_replace('/\D/', '', $num);
            if (strlen($num) === 10) {
                return '0' . $num;
            }
            return $num;
        }, $numbers);

        return response()->view('exotel.flow', [
            'numbers' => $normalizedNumbers
        ])->header('Content-Type', 'text/xml');
    }

    private function errorResponse(string $message)
    {
        Log::channel('exotel')->error('Exotel Flow Error', ['message' => $message]);
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<Response><Hangup /></Response>';
        
        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}
