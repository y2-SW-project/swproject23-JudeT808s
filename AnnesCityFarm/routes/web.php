<?php

use App\Http\Controllers\Admin\AnimalController as AdminAnimalController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\VolunteerController as AdminVolunteerController;
use App\Http\Controllers\User\AnimalController as UserAnimalController;
use App\Http\Controllers\User\ReviewController as UserReviewController;
use App\Http\Controllers\User\ArticleController as UserArticleController;
use App\Http\Controllers\User\VolunteerController as UserVolunteerController;
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

Route::get('welcome', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about');
})->name('info');

Route::get('gallery', [App\Http\Controllers\User\AnimalController::class, 'index'])->name('gallery');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
// Route::get('/', [AdminArticleController::class, 'index'])->name('admin.articles.index');
Route::get('/', [UserAnimalController::class, 'search']);
// Resource routes for articles
Route::resource('/admin/article', AdminArticleController::class)->middleware(['auth'])->names('admin.articles');
Route::resource('/user/article', UserArticleController::class)->middleware(['auth'])->names('user.articles')->only(['index', 'show']);

// Resource routes for animals
Route::resource('/admin/animal', AdminAnimalController::class)->middleware(['auth'])->names('admin.animals');
Route::resource('/user/animal', UserAnimalController::class)->middleware(['auth'])->names('user.animals')->only(['index', 'show']);

// Resource routes for volunteers
Route::resource('/admin/volunteer', AdminVolunteerController::class)->middleware(['auth'])->names('admin.volunteers')->only(['index', 'show']);
Route::resource('/user/volunteer', UserVolunteerController::class)->middleware(['auth'])->names('user.volunteers');

Route::resource('/admin/review', AdminReviewController::class)->middleware(['auth'])->names('admin.reviews')->only(['index', 'show']);
Route::resource('/user/review', UserReviewController::class)->middleware(['auth'])->names('user.reviews');

// Custom route for storing reviews
Route::post('review.store', [UserReviewController::class, 'store'])->name('review.store')->middleware(['auth']);

// Delete images routes
Route::delete('/articles/{article}/images/{image}', [AdminArticleController::class, 'deleteImage'])->name('articles.images.delete')->middleware(['auth']);
Route::delete('/animals/{animal}/images/{image}', [AdminAnimalController::class, 'deleteImage'])->name('animals.images.delete')->middleware(['auth']);

// View image routes
Route::get('/article/{article}/image/{image}', [AdminArticleController::class, 'viewImage'])->name('article.viewImage');
Route::get('/animal/{animal}/image/{image}', [AdminAnimalController::class, 'viewImage'])->name('animal.viewImage');
