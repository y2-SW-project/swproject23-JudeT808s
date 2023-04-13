<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Animal;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Images>
 */
// Relation::morphMap([
//     'animal' => Animal::class,
//     'article' => Article::class,
//      'image' => Image::class,
// ]);

class ImageFactory extends Factory
{

    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageable = $this->faker->randomElement([
            Article::class,
            Animal::class
        ]);

        return [
            'filename' =>  $this->faker->imageUrl(640, 480, 'animals', true),
            'type' => $this->faker->name,
            'path' => $this->faker->name,
            'imageable_id' => $imageable::factory(),
            'imageable_type' =>  array_search($imageable, Relation::$morphMap),
        ];
    }
}
