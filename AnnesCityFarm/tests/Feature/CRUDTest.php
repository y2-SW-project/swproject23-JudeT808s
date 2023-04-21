<?php

namespace Tests\Feature;

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Review;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CRUDTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test creating a new article
     *
     * @return void
     */
    public function test_can_create_review()
    {
        ob_start();

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $data = [
            'name' => $this->faker->name,
            'stars' => $this->faker->numberBetween(0, 5),
            'body' => $this->faker->text,
            'user_id' => $user->id,
        ];

        $response = $this->post(route('user.reviews.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'name', 'stars', 'body', 'created_at', 'updated_at',
        ]);
        $response->assertJson([
            'name' => $data['name'],
            'stars' => $data['stars'],
            'body' => $data['body'],
        ]);

        $review = Review::first();
        $this->assertNotNull($review);

        $this->assertEquals($data['name'], $review->name);
        $this->assertEquals($data['stars'], $review->stars);
        $this->assertEquals($data['body'], $review->body);


        ob_end_clean();
    }

    /**
     * Test reading/viewing an re
     *
     * @return void
     */
    public function test_can_read_review()
    {
        ob_start();

        // Create a user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create an re belonging to the user
        $review = Review::create([
            'name' => 'Test review',
            'stars' => '3',
            'body' => 'Test Body',
            'user_id' => $user->id,
        ]);

        // Make a GET request to view the review
        $response = $this->get(route('user.reviews.review', ['review' => $review->id]));

        // Assert that the response is successful and returns the correct view
        $response->assertSuccessful();
        $response->assertViewIs('user.reviews.review');

        // Assert that the article and the user who created it are passed to the view
        $response->assertViewHas('review', $review);
        $response->assertViewHas('user', $user);
        ob_end_clean();
    }

    public function test_can_update_review()
    {
        ob_start();

        // Create a user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create an article belonging to the user
        $review = Review::create([
            'name' => 'Test review',
            'stars' => '3',
            'body' => 'Test Body',
            'user_id' => $user->id,
        ]);

        // Make a PUT request to update the article
        $response = $this->put(route('user.reviews.update', ['review' => $review->id]), [
            'name' => 'Test review',
            'body' => 'Test Body',
        ]);

        // Reload the article from the database
        $review->refresh();

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that the article was updated with the new values
        $this->assertEquals('Test review', $review->name);
        $this->assertEquals('Test Body', $review->body);
        ob_end_clean();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        ob_get_clean();
        // Close the database connection
        DB::disconnect();
    }
}
