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
            'whatsapp_number' => 'nullable|string',
            'secondary_call_number' => 'nullable|string',
            'is_emergency_link' => 'nullable|boolean',
            'is_call_icon' => 'nullable|boolean',
            'is_whatsapp_icon' => 'nullable|boolean',
        ]);

        $setting = Setting::first();
        $data = $request->only('email', 'contact_number', 'emergency_number', 'non_emergency_number', 'whatsapp_number', 'secondary_call_number', 'is_emergency_link', 'is_call_icon', 'is_whatsapp_icon');
        
        // Handle checkboxes: if not present in request, set to 0
        $data['is_emergency_link'] = $request->has('is_emergency_link') ? 1 : 0;
        $data['is_call_icon'] = $request->has('is_call_icon') ? 1 : 0;
        $data['is_whatsapp_icon'] = $request->has('is_whatsapp_icon') ? 1 : 0;

        // Backend Mutual Exclusivity
        if (!empty($data['emergency_number'])) {
            $data['is_emergency_link'] = 0;
        }
        if ($data['is_emergency_link'] == 1) {
            $data['emergency_number'] = null;
        }

        if (!empty($data['whatsapp_number'])) {
            // Number exists, usually icon should be 1 if we are saving, but user might want to hide it
            // So we don't force it here, but we enforce the dependency:
        }
        if ($data['is_whatsapp_icon'] == 0) {
            $data['whatsapp_number'] = null;
        }

        if ($setting) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return redirect()->route('setting.index')->with('success', 'Settings updated successfully.');
    }
}
