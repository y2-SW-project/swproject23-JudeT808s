<?php

use App\Models\User;
use App\Models\Admin;
use Faker\Factory as Faker;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use Illuminate\Database\Eloquent\Relations\Relation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/hi', function () {
    //     $faker = Faker::create();
    //     $imageable = $faker->randomElement([
    //         Article::class,
    //     ]);
    //     // $user = User::create([
    //     //     'name' => 'Heffo',
    //     //     'email' => 'predator@example.com',
    //     //     'password' => Hash::make('password'),
    //     //     'email_verified_at' => now(),
    //     // ]);

    //     $article = Article::create([
    //         'title' => 'Joel',
    //         'subtitle' => 'Time',
    //         'publish_date' => '2013/6/23.',
    //         'admin_id' => '1',
    //     ]);
    //     $article->images()->create([
    //         'filename' => 'asdasd',
    //         'type' => 'example',
    //         'path' => 'example',
    //     ]);
    //     $article = Article::find(1);

    //     $article->images()->create([
    //         'filename' => 'asdasd',
    //         'type' => 'example',
    //         'path' => 'example',
    //         'imageable_id' => $imageable::factory(),
    //         'imageable_type' =>  array_search($imageable, Relation::$morphMap),
    //     ]);

    //     dd($article->images->first()->filename);
    //     return view('welcome');
});
Route::get('/main', function () {
    return view('main');
});

Auth::routes();


Route::get('/article-create', [ArticleController::class, 'create'])->name('article-create');
Route::put('/article/{article}', [ArticleController::class, 'update'])->name('article-update');

// Route::put('article-update', [ArticleController::class, 'update'])->name('update');

Route::get('/article/edit/{article}', [ArticleController::class, 'edit'])->name('article-edit');
Route::get('/', [ArticleController::class, 'index']);
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('show');
Route::post('article.store', [ArticleController::class, 'store'])->name('article.store');

//Route::resource('/', ArticleController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
