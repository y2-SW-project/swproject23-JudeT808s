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
            'imageable_id' => $imageable->id,
            'imageable_type' =>  $imageable->getMorphClass(),
            //  'imageable_id' => $imageable::factory(),
            //  'imageable_type' =>  $imageable,
        ];
    }
    public function configure()
    {
        return $this->for(
            $this->imageable(),
            'imageable',
        );
    }
    //This works but only seems to take one article to seed all to
    // public function configure()
    // {
    //     return $this->for(
    //         static::factoryForModel($this->imageable()),
    //         'imageable',
    //     );
    // }
    // public function imageable()
    // {
    //     return $this->faker->randomElement([
    //         Article::class
    //     ])->create();
    // }
    //End

    public function imageable()
    {
        $model = $this->faker->randomElement([
            Article::class
        ]);
        return $model::factory()->create();
    }
}
