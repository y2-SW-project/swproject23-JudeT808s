<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
   
    protected $model = \App\Models\Article::class;
    // protected $article = Article::class;
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
            'admin_id' => Admin::pluck('id')->random(),
            // 'images' => $this->faker->image('storage/app/public/images', 400, 300, null, false)
            // 'image' =>  $this->faker->imageUrl(640, 480, 'animals', true),
        ];
    }
}