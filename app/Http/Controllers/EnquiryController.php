<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Hospital;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    //

    public function index(Request $request){
        $query = Enquiry::with('hospital');

        if ($request->filled('patient_name')) {
            $query->where('patient_name', 'LIKE', '%' . $request->patient_name . '%');
        }

        if ($request->filled('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enquiry = $query->latest()->get();
        $hospitals = Hospital::all();
       
        return view('backend.enquiry.index', compact('enquiry', 'hospitals'));
    }

    public function status(Request $request, $id){
        $partner = Enquiry::findOrFail($id);
        $partner->status = $request->input('status');
        $partner->save();
    
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function destroy($id){
        $hospital = Enquiry::findOrFail($id);
        $hospital->delete();
        
        return redirect()->route('enquiry.index')->with('success', 'Enquiry deleted successfully.');
    }
}
