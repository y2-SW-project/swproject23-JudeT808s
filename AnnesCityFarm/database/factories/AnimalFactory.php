<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Animal;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{

    protected $model = \App\Models\Animal::class;
    // protected $article = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'age' => $this->faker->randomDigit,
            'description' => $this->faker->text,
            'user_id' => Admin::pluck('id')->random(),
            // 'images' => $this->faker->image('storage/app/public/images', 400, 300, null, false)
            // 'image' =>  $this->faker->imageUrl(640, 480, 'animals', true),
        ];
    }
}
