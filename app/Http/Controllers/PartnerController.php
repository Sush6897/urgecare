<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'businessName' => 'required|string|max:255',
            'contact' => 'required|digits_between:10,15| numeric', // Allow only numeric values between 10 and 15 digits
            'email' => 'required|email|max:255|unique:partners,email',
            'address' => 'required|string|max:500',
        ]);

        Partner::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'business_name' => $request->input('businessName'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        return redirect()->back()->with('success', 'Partner details saved successfully.');
    }

    public function index(){
        $partners= Partner::all();
        return view('backend.partner', compact('partners'));
    }
    public function updateStatus(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->status = $request->input('status');
        $partner->save();
    
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function destroy($id){
        $hospital = Partner::findOrFail($id);
        $hospital->delete();
        
        return redirect()->route('partners.create')->with('success', 'Partner deleted successfully.');
    }
}


