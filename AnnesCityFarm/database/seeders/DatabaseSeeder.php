<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Database\Seeders\SpeciesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        // \App\Models\Species::factory(5)->create();
        \App\Models\User::factory(1)->create();
        \App\Models\Review::factory(5)->create();
        $this->call(DaySeeder::class);
        \App\Models\Image::factory(10)->create();
        // \App\Models\Article::factory(0)->create();
        $this->call(SpeciesSeeder::class);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}