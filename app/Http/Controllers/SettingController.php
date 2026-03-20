<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('backend.setting.index', compact('setting'));
    }

    public function create()
    {
        $setting = Setting::first();
        return view('backend.setting.create', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'contact_number' => 'nullable|string',
            'emergency_number' => 'nullable|string',
            'non_emergency_number' => 'nullable|string',
        ]);

        $setting = Setting::first();
        
        if ($setting) {
            $setting->update($request->only('email', 'contact_number', 'emergency_number', 'non_emergency_number'));
        } else {
            Setting::create($request->only('email', 'contact_number', 'emergency_number', 'non_emergency_number'));
        }

        return redirect()->route('setting.index')->with('success', 'Settings updated successfully.');
    }
}
