<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Article;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Images>
 */

class ImageFactory extends Factory
{

    protected $model = Image::class;

    /**
     * Define the model's default state.
     * 
     
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageable = $this->imageable();
        return [
            'filename' =>  $this->faker->imageUrl(640, 480, 'animals', true),
            'type' => $this->faker->name,
            'path' => $this->faker->name,
            'imageable_id' => $imageable::factory(),
            'imageable_type' =>  $imageable,
        ];
    }
    public function imageable()
    {
        $images = Image::factory()->count(1)->for(
            Article::factory(),
            'imageable'
        )->create();

        return $this->faker->randomElement([
            Article::class,
            // Animal::class,
        ]);
    }
}
