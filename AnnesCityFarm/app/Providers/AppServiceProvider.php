<?php

namespace App\Providers;

use App\Models\Image;
use App\Models\Animal;
use App\Models\Article;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'image' => Image::class,
            'article' => Article::class,
            'animal' => Animal::class,
        ]);
    }
}
