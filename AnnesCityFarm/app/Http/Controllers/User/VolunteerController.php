<?php

namespace App\Http\Controllers\User;

use App\Models\Day;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public function create()
    {
        $days = Day::all();
        return view('user.volunteers.volunteer-create')->with('days', $days);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->authorizeRoles('user');

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'age' => 'required',
            'phoneNo' => 'required',
        ]);



        $volunteer = new Volunteer();
        $volunteer->first_name = $request->input('first_name');
        $volunteer->last_name = $request->input('last_name');
        $volunteer->address = $request->input('address');
        $volunteer->age = $request->input('age');
        $volunteer->phoneNo = $request->input('phoneNo');
        $volunteer->user_id = $user->id;
        $volunteer->save();

        $volunteer->days()->attach($request->days);

        // Render the view with the images
        return redirect('home');
    }
}