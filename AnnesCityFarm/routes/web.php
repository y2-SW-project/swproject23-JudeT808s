<?php

use App\Http\Controllers\ArticleController;
use App\Models\Admin;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // $user = User::create([
    //     'name' => 'Heffo',
    //     'email' => 'predator@example.com',
    //     'password' => Hash::make('password'),
    //     'email_verified_at' => now(),
    // ]);

    // $article = Article::create([
    //     'title' => 'Joel',
    //     'subtitle' => 'Time',
    //     'publish_date' => '2013/6/23.',
    //     'user_id' => '1',
    // ]);
    // $article->images()->create([
    //     'user_id' => $user->id,
    //     'filename' => 'asdasd',
    //     'type' => 'example',
    //     'path' => 'example',
    // ]);
    // $article = Article::find(1);

    // $article->images()->create([
    //     'user_id' => 1,
    //     'filename' => 'asdasd',
    //     'type' => 'example',
    //     'path' => 'example',
    // ]);
    // dd($article->images);
    return view('welcome');
});
// Route::get('/main', function () {
//     return view('main');
// });

Auth::routes();
Route::get('/', function () {
    return view('welcome', [\App\Http\Controllers\ArticleController::class, 'articles' => Article::all()]);
});
//Route::resource('/', ArticleController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');