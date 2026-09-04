<?php

namespace App\Http\Controllers;

use App\Models\PatientLocationLog;
use App\Models\PatientLocationSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientLocationController extends Controller
{
    /**
     * Start or resume a 1-hour location tracking session.
     */
    public function startSession(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $token = $request->input('session_token');
        $session = null;

        if ($token) {
            $session = PatientLocationSession::where('session_token', $token)
                ->where('is_active', true)
                ->where('expires_at', '>', Carbon::now())
                ->first();
        }

        if (!$session) {
            $token = 'pts_' . Str::random(32);
            $now = Carbon::now();
            $session = PatientLocationSession::create([
                'session_token' => $token,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'start_latitude' => $request->latitude,
                'start_longitude' => $request->longitude,
                'current_latitude' => $request->latitude,
                'current_longitude' => $request->longitude,
                'movement_status' => 'stopped',
                'current_speed' => 0,
                'total_distance_meters' => 0,
                'started_at' => $now,
                'expires_at' => $now->copy()->addHour(),
                'is_active' => true,
            ]);

            // Add initial location log
            PatientLocationLog::create([
                'session_id' => $session->id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'speed' => 0,
                'movement_status' => 'stopped',
                'accuracy' => $request->input('accuracy'),
                'recorded_at' => $now,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'session_token' => $session->session_token,
            'expires_at' => $session->expires_at->toIso8601String(),
            'remaining_seconds' => $session->remaining_seconds,
            'movement_status' => $session->movement_status,
        ]);
    }

    /**
     * Receive periodic location update pings from patient browser.
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'session_token' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $session = PatientLocationSession::where('session_token', $request->session_token)->first();

        if (!$session) {
            return response()->json(['status' => 'error', 'message' => 'Invalid session token'], 404);
        }

        // Check 1-hour expiration window
        if (!$session->is_active || Carbon::now()->greaterThanOrEqualTo($session->expires_at)) {
            $session->update(['is_active' => false]);
            return response()->json([
                'status' => 'expired',
                'message' => 'Tracking session expired (1 hour limit completed)',
                'remaining_seconds' => 0,
            ]);
        }

        $now = Carbon::now();
        $lat = (float) $request->latitude;
        $lng = (float) $request->longitude;

        // Calculate distance and speed relative to last log
        $lastLog = PatientLocationLog::where('session_id', $session->id)->orderBy('recorded_at', 'desc')->first();
        $distance = 0;
        $speedKmH = 0;

        if ($lastLog) {
            $distance = $this->calculateHaversineDistance(
                (float) $lastLog->latitude,
                (float) $lastLog->longitude,
                $lat,
                $lng
            );

            $secondsElapsed = max(1, $now->diffInSeconds($lastLog->recorded_at));
            $speedKmH = ($distance / $secondsElapsed) * 3.6; // convert m/s to km/h
        }

        // Client speed override if provided (HTML5 geolocation returns speed in m/s)
        if ($request->has('speed') && is_numeric($request->speed) && $request->speed > 0) {
            $clientSpeedKmH = (float) $request->speed * 3.6;
            $speedKmH = max($speedKmH, $clientSpeedKmH);
        }

        // Movement status rule: > 1.5 km/h speed OR > 4 meters movement => 'walking'
        $movementStatus = ($speedKmH >= 1.5 || $distance >= 4.0) ? 'walking' : 'stopped';

        // Record log entry
        PatientLocationLog::create([
            'session_id' => $session->id,
            'latitude' => $lat,
            'longitude' => $lng,
            'speed' => round($speedKmH, 2),
            'movement_status' => $movementStatus,
            'accuracy' => $request->input('accuracy'),
            'recorded_at' => $now,
        ]);

        // Update active session
        $session->update([
            'current_latitude' => $lat,
            'current_longitude' => $lng,
            'movement_status' => $movementStatus,
            'current_speed' => round($speedKmH, 2),
            'total_distance_meters' => round($session->total_distance_meters + $distance, 2),
        ]);

        return response()->json([
            'status' => 'success',
            'movement_status' => $movementStatus,
            'speed' => round($speedKmH, 2),
            'distance_moved_m' => round($distance, 2),
            'total_distance_m' => round($session->total_distance_meters, 2),
            'remaining_seconds' => $session->remaining_seconds,
        ]);
    }

    /**
     * Admin view for live patient tracking.
     */
    public function adminIndex()
    {
        $activeSessions = PatientLocationSession::active()->orderBy('updated_at', 'desc')->get();
        $totalActive = $activeSessions->count();
        $walkingCount = $activeSessions->where('movement_status', 'walking')->count();
        $stoppedCount = $activeSessions->where('movement_status', 'stopped')->count();

        $recentSessions = PatientLocationSession::orderBy('created_at', 'desc')->take(50)->get();

        return view('backend.patient_tracking.index', compact('activeSessions', 'totalActive', 'walkingCount', 'stoppedCount', 'recentSessions'));
    }

    /**
     * API for Admin Live Map Polling.
     */
    public function getActiveSessions()
    {
        // Fetch sessions created within last 24 hours
        $sessions = PatientLocationSession::where('created_at', '>=', Carbon::now()->subHours(24))
            ->with(['logs' => function ($q) {
                $q->orderBy('recorded_at', 'asc');
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        $formatted = $sessions->map(function ($s) {
            return [
                'id' => $s->id,
                'session_token' => $s->session_token,
                'ip_address' => $s->ip_address,
                'current_latitude' => (float) ($s->current_latitude ?? $s->start_latitude ?? 0),
                'current_longitude' => (float) ($s->current_longitude ?? $s->start_longitude ?? 0),
                'start_latitude' => (float) ($s->start_latitude ?? 0),
                'start_longitude' => (float) ($s->start_longitude ?? 0),
                'movement_status' => $s->movement_status ?? 'stopped',
                'current_speed' => (float) ($s->current_speed ?? 0),
                'total_distance_meters' => (float) ($s->total_distance_meters ?? 0),
                'started_at' => $s->started_at ? $s->started_at->format('d M Y, h:i A') : $s->created_at->format('d M Y, h:i A'),
                'expires_at' => $s->expires_at ? $s->expires_at->toIso8601String() : '',
                'remaining_seconds' => $s->remaining_seconds,
                'is_active' => (bool) ($s->is_active && ($s->remaining_seconds > 0)),
                'last_updated' => $s->updated_at ? $s->updated_at->diffForHumans() : 'Just now',
                'logs' => $s->logs->map(function ($l) {
                    return [
                        'lat' => (float) $l->latitude,
                        'lng' => (float) $l->longitude,
                        'speed' => (float) $l->speed,
                        'status' => $l->movement_status,
                        'time' => $l->recorded_at ? $l->recorded_at->format('h:i:s A') : $l->created_at->format('h:i:s A'),
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 'success',
            'count' => $formatted->count(),
            'sessions' => $formatted,
        ]);
    }

    /**
     * API for fetching specific session route history.
     */
    public function getSessionTrack($id)
    {
        $session = PatientLocationSession::with('logs')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'session' => [
                'id' => $session->id,
                'session_token' => $session->session_token,
                'ip_address' => $session->ip_address,
                'movement_status' => $session->movement_status,
                'total_distance_m' => $session->total_distance_meters,
                'started_at' => $session->started_at->format('d M Y, h:i A'),
                'expires_at' => $session->expires_at->format('d M Y, h:i A'),
                'is_active' => $session->is_active && ($session->remaining_seconds > 0),
            ],
            'breadcrumbs' => $session->logs->map(function ($l) {
                return [
                    'lat' => (float) $l->latitude,
                    'lng' => (float) $l->longitude,
                    'speed' => $l->speed,
                    'status' => $l->movement_status,
                    'recorded_at' => $l->recorded_at->format('h:i:s A'),
                ];
            }),
        ]);
    }

    /**
     * Haversine formula to compute distance in meters between two lat/lng pairs.
     */
    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
