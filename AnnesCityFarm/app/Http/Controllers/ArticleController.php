<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {

        //This is how it looks
        // $images = $article->images->first()->filename;

        // $articles = Article::with('images')->get();
        // //Retro without eager loading
        // // $articles = Article::with('article')->pluck('images')->collapse();
        // return view('articles')->with('articles', $articles);
        $articles = Article::with('images')->get();
        $articles_by_filename = [];

        foreach ($articles as $article) {
            foreach ($article->images as $image) {
                $filename = $image->filename;
                $articles_by_filename[$filename][] = $article;
            }
        }

        return view('articles')->with([
            'articles' => $articles,
            'articles_by_filename' => $articles_by_filename,
        ]);
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
