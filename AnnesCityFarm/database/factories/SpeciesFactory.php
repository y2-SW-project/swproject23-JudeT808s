<?php

namespace Database\Factories;




use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class SpeciesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Species::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $names = ['Goat', 'Pig', 'Sheep', 'Pony', 'Donkey', 'Chicken'];

        return [
            'name' => Collection::make($names)->random(),
        ];
    }
}