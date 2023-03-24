<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'subtitle' => $this->faker->name,
            'publish_date' => $this->faker->date,
            'user_id' => '1',
            // 'images' => $this->faker->image('storage/app/public/images', 400, 300, null, false)
            // 'image' =>  $this->faker->imageUrl(640, 480, 'animals', true),
        ];
    }
}
// $article = Article::factory()->hasImages(1)->create();