<?php

namespace App\Http\Controllers;

use App\Services\ExotelService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Example JSON body for {@see initiateCall()}:
 *
 * <pre>
 * {
 *   "from": "09850382748",
 *   "numbers": ["07757911857", "09812345678"],
 *   "patient_name": "Optional name",
 *   "hospital_id": 1
 * }
 * </pre>
 */
class ExotelController extends Controller
{
    public function __construct(
        protected ExotelService $exotel
    ) {}

    public function initiateCall(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'from' => 'required|string|max:32',
            'numbers' => 'required|array|min:1',
            'numbers.*' => 'required|string|max:32',
            'patient_name' => 'sometimes|nullable|string|max:255',
            'hospital_id' => 'sometimes|nullable|integer|exists:hospitals,id',
        ]);

        $callLog = $this->exotel->createLogAndStartDial(
            $validated['from'],
            $validated['numbers'],
            $validated['patient_name'] ?? null,
            isset($validated['hospital_id']) ? (int) $validated['hospital_id'] : null
        );

        return response()->json([
            'message' => 'Sequential call started',
            'call_log_id' => $callLog->id,
            'current_index' => $callLog->current_index,
            'call_sid' => $callLog->call_sid,
            'status' => $callLog->status,
        ], 201);
    }

    public function handleCallback(Request $request): JsonResponse
    {
        $this->exotel->handleCallback($request);

        return response()->json(['status' => 'ok']);
    }
}
