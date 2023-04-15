<?php

namespace App\Http\Controllers\User;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create()
    {
        return view('reviews.review-create');
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
            'name' => 'required',
            'stars' => 'required',
            'body' => 'required',
        ]);

        $review = new Review();
        $review->name = $request->input('name');
        $review->stars = $request->input('stars');
        $review->body = $request->input('body');
        $review->user_id = $user->id;
        $review->save();

        // Render the view with the images
        return redirect('home');
    }
}
