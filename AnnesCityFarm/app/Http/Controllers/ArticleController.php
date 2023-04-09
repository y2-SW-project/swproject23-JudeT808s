<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article-create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        $images = Image::whereHasMorph('imageable', [$article->getMorphClass()], function ($query) use ($article) {
            $query->where('imageable_id', $article->getKey());
        })->get();
        $images_by_article[$article->id] = $images;

        // Render the view with the images
        return view('article', compact('article', 'images_by_article'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        return view('article', compact('article', 'images_by_article'));
    }


    // $article = Article::where('$articles->id =1');


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        // $user = Auth::user();
        // $user->authorizeRoles('admin');
        // //If user is not an authorized user they can not edit existing tournaments
        // if ($tournament->user_id != Auth::id()) {
        //     return abort(403);
        // }

        // $article = Article::findOrFail($article);


        //Returns the edit.blade.php page with an array of teams
        //$article = Article::find($id);
        $image = $article->images->first();

        // return view('article-edit', compact('article', 'image'));
        //->with('article', $article);
        return view('article-edit')->with('article', $article)->with('image', $image);
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
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'publish_date' => 'required',
        ]);

        $article->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'publish_date' => $request->publish_date,
            'admin_id' => '1',
        ]);

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
        return view('article', compact('article', 'images_by_article'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $user->authorizeRoles('admin');
        //Gets teams M:N to detatch foreign key
        // $article->imageable()->detach();
        //drops team_id where equals tournament id that is deleted
        // DB::table('team_tournament')->where('team_id', $tournament->id)->delete();
        // // $tournament->teams()->delete();
        // $tournament->delete();

        // return to_route('admin.tournament.index')->with('success', 'Tournament deleted successfully');
    }
}
