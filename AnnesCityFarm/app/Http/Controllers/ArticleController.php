<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('images')->get();

        $articles_with_images = $articles->filter(function ($article) {
            return $article->images->count() > 0;
        });

        $images_by_article = [];

        foreach ($articles_with_images as $article) {
            $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
                $query->where('imageable_id', $article->getKey());
            })->get();

            $images_by_article[$article->id] = $images;
        }

        return view('welcome', compact('articles', 'images_by_article'));
    }

    // return Image::query()->whereMorphedTo('imageable', $articles)
    // ->where('imageable_id', $articles->getKey())->get();

    //This is how it looks
    // $images = $article->images->first()->filename;

    // $articles = Article::with('images')->get();
    // //Retro without eager loading
    // // $articles = Article::with('article')->pluck('images')->collapse();
    // return view('articles')->with('articles', $articles);
    // $articles = Article::with('images')->get();
    // $images = Images::class;
    // $articles_by_filename = [];

    // foreach ($articles as $article) {
    //     foreach ($article->images as $image) {
    //         $filename = $image->filename;
    //         $articles_by_filename[$filename][] = $article;
    //     }
    // }
    // // foreach($images as $image->imageable_id){
    // //     foreach($articles as $article){
    // //         $imageName = 
    // //     }
    // // }

    // return view('welcome')->with([
    //     'articles' => $articles,
    //     'articles_by_filename' => $articles_by_filename
    // ]);


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Article $articles)
    {
        $article = Article::where('$articles->id =1');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}