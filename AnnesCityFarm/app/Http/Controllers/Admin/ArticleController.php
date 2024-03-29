<?php

namespace App\Http\Controllers\Admin;

use App\User;
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
        //Gets only the first 3 articles sorted by date created
        $articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        //Gets 6 animals with the one to many species
        $animals = Animal::with('images')->with('species')->orderBy('created_at', 'desc')->take(6)->get();
        //Gets reviews which can be paginated
        $reviews = Review::paginate(3);
        //Only fill array with an animal that has images
        $articles_with_images = $articles->filter(function ($article) {
            return $article->images->count() > 0;
        });
        //Instantiates array
        $images_by_article = [];
        //Loops through all article with images that are morphed to specific article
        foreach ($articles_with_images as $article) {
            $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
                $query->where('imageable_id', $article->getKey());
            })->get();

            $images_by_article[$article->id] = $images;
        }
        //Only fill array with an animal that has images

        $animals_with_images = $animals->filter(function ($animal) {
            return $animal->images()->count() > 0;
        });
        $images_by_animal = [];
        //Loops through all animal with images that are morphed to specific animal
        foreach ($animals_with_images as $animal) {
            $images = Image::whereHasMorph('imageable', [$animal->getMorphClass()], function ($query) use ($animal) {
                $query->where('imageable_id', $animal->getKey());
            })->get();
            $images_by_animal[$animal->id] = $images;
        }
        // dd($images_by_animal);

        return view('admin.welcome', compact('articles', 'images_by_article', 'animals', 'images_by_animal', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        return view('admin.articles.article-create');
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
        $user->authorizeRoles('admin');

        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'publish_date' => 'required',
        ]);

        $article = new Article();
        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->publish_date = $request->input('publish_date');
        $article->admin_id = $user->id;
        $article->save();

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images', $filename, 'public');

        $article->images()->create([
            'filename' => $filename,
            'type' => $image->getClientMimeType(),
            'path' => $path,
        ]);
        //Sets image to morph to Animal class 

        $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
            $query->where('imageable_id', $article->getKey());
        })->get();
        $images_by_article[$article->id] = $images;

        //saving the animal id as the imageable_id
        return view('admin.articles.article', compact('article', 'images_by_article'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $article = Article::where('id', $id)->firstOrFail();

        if (!$article) {
            abort(404);
        }

        $article->load('images');

        $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
            $query->where('imageable_id', $article->getKey());
        })->get();

        $images_by_article[$article->id] = $images;

        // Render the view with the images
        return view('admin.articles.article', compact('article', 'images_by_article'))->with('article', $article)->with('images', $images);
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');
        $article->load('images');

        $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
            $query->where('imageable_id', $article->getKey());
        })->get();

        //Returns the edit.blade.php page with an array of teams
        $images_by_article[$article->id] = $images;

        return view('admin.articles.article-edit')->with('article', $article)->with('images', $images);
    }

    /**
     * Update the specified article in storage.
     *     * @return \Illuminate\Http\Response

     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'publish_date' => 'required',
        ]);

        $article->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'publish_date' => $request->publish_date,
            'admin_id' => $user->id,
        ]);

        // Log::debug('Update method called for article ID ' . $article->id);

        //Conditional statement if edited image has image get file  being saved to storage with filename being saved as time and image filename
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');

            $article->images()->create([
                'filename' => $filename,
                'type' => $image->getClientMimeType(),
                'path' => $path,
                'imageable_id' => $article->id,
                'imageable_type' => 'article',
            ]);
        }

        $articles = Article::orderBy('publish_date', 'desc')->get();
        $images_by_article = Image::whereIn('article_id', $articles->pluck('id'))->get()->groupBy('article_id');
        return redirect()->route('admin.articles.show', ['article' => $article->id]);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Article has been deleted successfully!');
    }

    public function deleteImage(Article $article, Image $image)
    {
        $user = Auth::user();
        $user->authorizeRoles('admin');

        // Check if the article and image exist and are related
        if ($article->images->contains($image)) {
            // Delete the image from storage
            Storage::disk('public')->delete($image->path);

            // Delete the image record from the database
            $image->delete();

            return response()->json(['message' => 'Image deleted successfully'], 200);
        }

        return response()->json(['error' => 'Image not found or not associated with the article'], 404);
    }
}
