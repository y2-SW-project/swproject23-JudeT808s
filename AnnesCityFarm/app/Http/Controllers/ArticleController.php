<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        // $user->authorizeRoles('admin');

        //$books = Book::all();
        // $books = Book::paginate(10);
        // $books = Book::with('publisher')->get();
        // $articles = Article::with('article')
        //     ->get();
        $articles = Article::with('images')->get();
        //Retro without eager loading
        // $articles = Article::with('article')->pluck('images')->collapse();
        return view('articles')->with('articles', $articles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'publish_date' => 'required',
        ]);

        $article = new Article();
        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->publish_date = $request->input('publish_date');
        $article->save();

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $filename, 'public');



        $article->images()->create([
            'filename' => $filename,
            'type' => $image->getClientMimeType(),
            'path' => $path,
        ]);
    }
}
