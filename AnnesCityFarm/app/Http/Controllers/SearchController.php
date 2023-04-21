<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('q');

    $results = DB::table('animals')
        ->where('name', 'like', '%'.$query.'%')
        ->get();

    return view('search', compact('results'));
}
}