<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Animal;
use App\Models\Species;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Species::factory()
            ->times(2)
            ->hasAnimals(2)
            ->create()
            ->each(function ($species) {
                $species->animals->each(function ($animal) {
                    // Create and associate images with animals
                    Image::factory()->count(3)->create([
                        'imageable_id' => $animal->id,
                        'imageable_type' => array_search(get_class($animal), Relation::$morphMap),
                    ]);
                });
            });
    }
}
