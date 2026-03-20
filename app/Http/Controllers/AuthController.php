<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Enquiry;
use App\Models\Hospital;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PDO;

class AuthController extends Controller
{
    //
    public function showResetForm(Request $request){
        $passwordReset = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        return view('auth.resetpassword', compact('passwordReset'));
    }


    public function index(){
        return view('auth.login');
    }
    public function forgotPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Create a token for the password reset
        $token = Str::random(60);
        // Save the token to the password_resets table (assuming you have this set up)
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send the email using Mail::send
        Mail::send('email.custom_reset_password', ['user' => $user, 'token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Your Password');
        });

        return back()->with('success', 'Password reset link has been sent to your email address.');
    }
    public function reset(Request $request){
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
            return back()->with('error' ,'Invalid token!');
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', "We can't find a user with that email address.");
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset!');
    }

    public function forgetPassword(){
        return view('auth.forget-password');
    }

    public function dashboard(){

        $hospitalCount = Hospital::count();
        $partnerCount = Partner::count();
        $contactCount = Contact::count();
        $enquiryCount = Enquiry::count();

        return view('backend.dashboard',compact('hospitalCount', 'partnerCount', 'contactCount', 'enquiryCount'));
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials=$request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');

        }else{
            return back()->with('error', 'Credentials Not Found');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function profile(){
        return view('backend.profile');
    }

    public function profileUpdate(Request $request){
        $request->validate([
            'name'=> "required|string|max:255|alpha",
        ]);
        // dd($request->all());
        $data=[
            "name"=>$request->name,
            'email'=>$request->email,
        ];
        $user = User::where('id', auth()->user()->id)->update($data);
        if($user){
            return redirect()->route('dashboard')->with('success', 'Profile Update Sucessfully');
        }else{
            return back();
        }

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if ($user) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('status', 'Password updated successfully!');
        }
        // dd("hii");
        return redirect()->back()->withErrors(['user' => 'User not found.']);
    }
}
