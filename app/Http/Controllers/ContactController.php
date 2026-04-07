<?php 

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:contacts,email',
            'phone' => 'required|digits_between:10,15|numeric',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Store contact data in the database
        Contact::create($request->all());

        return back()->with('success', 'Your message has been sent successfully!');
    }

    public function index(Request $request){
        $query = Contact::query();

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        $Contact = $query->latest()->get();
        return view('backend.contact',compact('Contact'));
    }

    public function destroy($id){
        
        $hospital = Contact::findOrFail($id);
        $hospital->delete();
        
        return redirect()->route('contact.create')->with('success', 'Contact deleted successfully.');
    }

   
}
