<?php

namespace Database\Factories;




use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\species>
 */
class SpeciesFactory extends Factory
{
    protected $model = \App\Models\Species::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' =>   $this->faker->name,

        ];
    }
}
