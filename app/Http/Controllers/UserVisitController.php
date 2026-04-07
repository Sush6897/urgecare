<?php

namespace App\Http\Controllers;

use App\Models\UserVisit;
use Illuminate\Http\Request;

class UserVisitController extends Controller
{
    public function index()
    {
        $visits = UserVisit::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.user_visits.index', compact('visits'));
    }

    public function destroy($id)
    {
        $visit = UserVisit::findOrFail($id);
        $visit->delete();
        return back()->with('success', 'Visit record deleted successfully.');
    }
}
