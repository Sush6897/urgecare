<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    //

    public function index(){

        $enquiry=Enquiry::with('hospital')->get();
       
        return view('backend.enquiry.index', compact('enquiry'));
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
