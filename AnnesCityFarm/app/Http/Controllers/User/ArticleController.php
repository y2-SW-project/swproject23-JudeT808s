<?php

namespace App\Http\Controllers\User;

use App\Models\Image;
use App\Models\Animal;
use App\Models\Review;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;
use Illuminate\Database\Eloquent\Relations\Relation;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        $animals = Animal::with('images')->with('species')->orderBy('created_at', 'desc')->take(6)->get();
        $reviews = Review::paginate(3);

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
        // dd($animals);
        $animals_with_images = $animals->filter(function ($animal) {
            return $animal->images()->count() > 0;
        });
        // dd($animals_with_images);
        $images_by_animal = [];

        foreach ($animals_with_images as $animal) {
            $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
                $query->where('imageable_id', $animal->getKey());
            })->get();
            $images_by_animal[$animal->id] = $images;
        }
        // dd($images_by_animal);

        return view('welcome', compact('articles', 'images_by_article', 'animals', 'images_by_animal', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::where('id', $id)->firstOrFail();
        $suggested = Article::where("species_id" == $article->species_id && "id" !== $article->id);
        if (!$article) {
            abort(404);
        }
        $article->load('images');

        $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
            $query->where('imageable_id', $article->getKey());
        })->get();

        $images_by_article[$article->id] = $images;

        // Render the view with the images
        return view('user.articles.article', compact('article', 'images_by_article'));
    }
}
