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
        return view('user.reviews.review-create');
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
    public function show(Review $review)
    {
        return view('user.reviews.review')->with('review', $review);
    }
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'name' => 'required',
            'stars' => 'required',
            'body' => 'required',
        ]);

        $request->update([
            'name' => 'required',
            'stars' => 'required',
            'body' => 'required',
        ]);
        return redirect()->route('user.reviews.review', ['review' => $review->id]);
    }
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete();
        return redirect()->route('reviews.index')
            ->with('success', 'Review has been deleted successfully!');
    }
}