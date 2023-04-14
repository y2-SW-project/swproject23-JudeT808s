<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Volunteer;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\VolunteerController;
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
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\ArticleController::class, 'index'])->name('home');
Auth::routes();
Route::get('welcome', function () {
    return view('welcome');
});

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
// Route::get('/', [AnimalController::class, 'index'])->name('animals.index');

Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article-show');
Route::get('/animal/{id}', [AnimalController::class, 'show'])->name('animal-show');

Route::get('/article-create', [ArticleController::class, 'create'])->name('article-create');
Route::post('article.store', [ArticleController::class, 'store'])->name('article.store');

Route::get('/animal-create', [AnimalController::class, 'create'])->name('animal-create');
Route::post('animal.store', [AnimalController::class, 'store'])->name('animal.store');

Route::put('/article/{article}', [ArticleController::class, 'update'])->name('article-update');
Route::put('/animal/{animal}', [AnimalController::class, 'update'])->name('animal-update');

Route::get('/article/edit/{article}', [ArticleController::class, 'edit'])->name('article-edit');
Route::delete('/article/delete/{id}', [ArticleController::class, 'destroy'])->name('article-delete');

Route::get('/animal/edit/{animal}', [AnimalController::class, 'edit'])->name('animal-edit');
Route::delete('/animal/delete/{id}', [AnimalController::class, 'destroy'])->name('animal-delete');

//Volunteer
Route::get('/volunteer-create', [VolunteerController::class, 'create'])->name('volunteer-create');
Route::post('volunteer.store', [VolunteerController::class, 'store'])->name('volunteer.store');
Route::post('review.store', [ReviewController::class, 'store'])->name('review.store');



//Route::resource('/', ArticleController::class);

//Delete images
Route::delete('/articles/{article}/images/{image}', [ArticleController::class, 'deleteImage'])->name('articles.images.delete');
Route::delete('/animals/{animal}/images/{image}', [AnimalController::class, 'deleteImage'])->name('animals.images.delete');

// Route for viewing an image
Route::get('/article/{article}/image/{image}', [ArticleController::class, 'viewImage'])->name('article.viewImage');
Route::get('/animal/{animal}/image/{image}', [animalController::class, 'viewImage'])->name('animal.viewImage');
