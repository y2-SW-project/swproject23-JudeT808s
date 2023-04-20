<?php

namespace Tests\Feature;

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
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
    public function test_can_create_article()
    {
        ob_start();

        Storage::fake('public');

        $data = [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'publish_date' => $this->faker->date(),
            'image' => UploadedFile::fake()->image('article.jpg'),
        ];

        $response = $this->post(route('admin.articles.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id', 'title', 'subtitle', 'publish_date', 'created_at', 'updated_at',
        ]);
        $response->assertJson([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'publish_date' => $data['publish_date'],
        ]);

        $article = Article::first();
        $this->assertNotNull($article);

        $this->assertEquals($data['title'], $article->title);
        $this->assertEquals($data['subtitle'], $article->subtitle);
        $this->assertEquals($data['publish_date'], $article->publish_date);

        $image = $article->images->first();
        $this->assertNotNull($image);

        Storage::disk('public')->assertExists($image->path);
        ob_end_clean();
    }

    /**
     * Test reading/viewing an article
     *
     * @return void
     */
    public function test_can_read_article()
    {
        ob_start();

        // Create a user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create an article belonging to the user
        $article = Article::create([
            'title' => 'Test Article',
            'body' => 'Test Body',
            'user_id' => $user->id,
            'publish_date' => now(),
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);

        // Make a GET request to view the article
        $response = $this->get(route('admin.articles.article', ['article' => $article->id]));

        // Assert that the response is successful and returns the correct view
        $response->assertSuccessful();
        $response->assertViewIs('user.articles.show');

        // Assert that the article and the user who created it are passed to the view
        $response->assertViewHas('article', $article);
        $response->assertViewHas('user', $user);
        ob_end_clean();
    }

    public function test_can_update_article()
    {
        ob_start();

        // Create a user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create an article belonging to the user
        $article = Article::create([
            'title' => 'Test Article',
            'body' => 'Test Body',
            'user_id' => $user->id,
            'publish_date' => now(),
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);

        // Make a PUT request to update the article
        $response = $this->put(route('admin.articles.update', ['article' => $article->id]), [
            'title' => 'New Title',
            'body' => 'New Body',
        ]);

        // Reload the article from the database
        $article->refresh();

        // Assert that the response is successful
        $response->assertSuccessful();

        // Assert that the article was updated with the new values
        $this->assertEquals('New Title', $article->title);
        $this->assertEquals('New Body', $article->body);
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
