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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_article');
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
        $article->admin_id = '1';
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
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $article->load('images');

        $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
            $query->where('imageable_id', $article->getKey());
        })->get();

        $images_by_article[$article->id] = $images;

        // Render the view with the images
        return view('article', compact('article', 'images_by_article'));
    }


    // $article = Article::where('$articles->id =1');


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(article $article)
    {

        // $user = Auth::user();
        // $user->authorizeRoles('admin');
        // //If user is not an authorized user they can not edit existing tournaments
        // if ($tournament->user_id != Auth::id()) {
        //     return abort(403);
        // }


        // // get all teams from db
        // $teams = Team::all();
        // ->with( all teams ) 
        //Returns the edit.blade.php page with an array of teams
        return view('article.edit')->with('article', $article);
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
