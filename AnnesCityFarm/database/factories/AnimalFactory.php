<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Animal;
use App\Models\Article;
use App\Models\Species;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class AnimalFactory extends Factory
{
    protected $model = Animal::class;

    // protected $model = \App\Models\Animal::class;
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
            'admin_id' => Admin::pluck('id')->random(),
            'species_id' => Species::factory()->create()->id
        ];
    }
}
