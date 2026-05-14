<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use App\Models\Enquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Rules\AtLeastThreeFeatures;

class HospitalAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.hospital-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $hospital = Hospital::where('email', $request->email)->first();
        if ($hospital && $hospital->status !== 'active') {
            return back()->with('error', 'Your hospital account is currently inactive. Please contact administration.');
        }

        if (Auth::guard('hospital')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('hospital.dashboard'));
        }

        return back()->with('error', 'Invalid email or password provided.');
    }

    public function logout(Request $request)
    {
        Auth::guard('hospital')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('hospital.login');
    }

    public function dashboard()
    {
        $hospitalId = auth('hospital')->id();
        
        // Current Month
        $currentMonthCount = Enquiry::where('hospital_id', $hospitalId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Last Month
        $lastMonthCount = Enquiry::where('hospital_id', $hospitalId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // This Year
        $thisYearCount = Enquiry::where('hospital_id', $hospitalId)
            ->whereYear('created_at', now()->year)
            ->count();

        // Total
        $totalCount = Enquiry::where('hospital_id', $hospitalId)->count();

        // Latest 5 Enquiries
        $latestEnquiries = Enquiry::where('hospital_id', $hospitalId)
            ->latest()
            ->limit(5)
            ->get();

        return view('hospital.dashboard', compact(
            'currentMonthCount', 
            'lastMonthCount', 
            'thisYearCount', 
            'totalCount',
            'latestEnquiries'
        ));
    }

    public function enquiry(Request $request)
    {
        $hospitalId = auth('hospital')->id();
        $query = Enquiry::with('hospital')->where('hospital_id', $hospitalId);

        if ($request->filled('patient_name')) {
            $query->where('patient_name', 'LIKE', '%' . $request->patient_name . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enquiry = $query->latest()->get();
        return view('hospital.enquiry', compact('enquiry'));
    }

    public function profile()
    {
        $hospital = auth('hospital')->user()->load('contacts');

        return view('hospital.profile', compact('hospital'));
    }

    public function profileUpdate(Request $request)
    {
        $hospital = auth('hospital')->user();

        $request->validate([
            'hospital_name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals,email,' . $hospital->id,
            'address'       => 'required|string',
            'area'          => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'state'         => 'required|string|max:255',
            'country'       => 'required|string|max:255',
            'pincode'       => 'required|string|max:255',
            'gmap'          => 'required|url',
            'longitude'     => 'required|string|max:255',
            'latitude'      => 'required|string|max:255',
            'contacts'      => 'required|array|min:1',
            'contacts.*'    => 'required|digits:10',
            'features.features1' => ['nullable', 'string', 'max:255'],
            'features.features2' => ['nullable', 'string', 'max:255'],
            'features.features3' => ['nullable', 'string', 'max:255'],
            'features.features4' => ['nullable', 'string', 'max:255'],
            'features' => [new AtLeastThreeFeatures()],
            'type' => 'required|array',
            'type.*' => 'in:emergency,non-emergency',
            'price' => 'nullable|numeric',
        ], [
            'features' => 'At least three features are required.',
            'contacts' => 'At least one contact is required.',
        ]);

        $emergency = in_array('emergency', $request->type) ? 1 : 0;
        $nonemergency = in_array('non-emergency', $request->type) ? 1 : 0;

        $hospital->update([
            'hospital_name' => $request->hospital_name,
            'email'         => $request->email,
            'address'       => $request->address,
            'area'          => $request->area,
            'city'          => $request->city,
            'state'         => $request->state,
            'country'       => $request->country,
            'pincode'       => $request->pincode,
            'gmap'          => $request->gmap,
            'longitude'     => $request->longitude,
            'latitude'      => $request->latitude,
            'features1'     => $request->features['features1'] ?? null,
            'features2'     => $request->features['features2'] ?? null,
            'features3'     => $request->features['features3'] ?? null,
            'features4'     => $request->features['features4'] ?? null,
            'emergency'     => $emergency,
            'nonemergency'  => $nonemergency,
            'price'         => $request->price,
            'contact'       => $request->contacts[0] ?? null, // Sync primary contact
        ]);

        // Update contacts
        $hospital->contacts()->delete();
        foreach ($request->contacts as $contact) {
            if (!empty($contact)) {
                $hospital->contacts()->create([
                    'contact' => $contact
                ]);
            }
        }

        return redirect()->route('hospital.profile')
            ->with('success', 'Profile updated successfully.');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $hospital = auth('hospital')->user();
        $hospital->password = Hash::make($request->new_password);
        $hospital->save();

        return redirect()->route('hospital.profile')->with('success', 'Password updated successfully.');
    }

    public function forgetPassword()
    {
        return view('auth.hospital-forget-password');
    }

    public function submitForgetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $hospital = Hospital::where('email', $request->email)->first();

        if (!$hospital) {
            return back()->with('error', 'We can\'t find a hospital with that email address.');
        }

        $token = Str::random(60);
        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $hospital->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::send('email.hospital_reset_password', ['hospital' => $hospital, 'token' => $token], function ($message) use ($hospital) {
            $message->to($hospital->email);
            $message->subject('Reset Your Hospital Portal Password');
        });

        return back()->with('success', 'Password reset link has been sent to your email address.');
    }

    public function showResetForm(Request $request)
    {
        $passwordReset = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        
        if (!$passwordReset) {
            return redirect()->route('hospital.forget.password')->with('error', 'Invalid or expired password reset token.');
        }

        return view('auth.hospital-resetpassword', compact('passwordReset'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_reset_tokens')->where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();

        if (!$passwordReset) {
            return back()->with('error', 'Invalid token!');
        }

        $hospital = Hospital::where('email', $request->email)->first();
        if (!$hospital) {
            return back()->with('error', "We can't find a hospital with that email address.");
        }

        $hospital->password = Hash::make($request->password);
        $hospital->save();

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect()->route('hospital.login')->with('success', 'Your password has been reset successfully!');
    }
}
