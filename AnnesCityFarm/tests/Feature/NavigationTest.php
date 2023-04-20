<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;


class NavigationTest extends TestCase
{
    public function test_user_can_view_homepage()
    {
        // Simulate a GET request to the home page
        $response = $this->get('/login');

        // Assert that the response status code is 200
        $response->assertStatus(200);
    }
    public function test_user_can_navigate_to_about_page()
    {
        // Make a GET request to the home page
        $response = $this->get('/');

        $response = $this->followRedirects($response);

        // Assert that the response status code is 200
        $response->assertStatus(200);

        // Assert that the page contains a link to the about page
        $response->assertSee('About us');

        // Follow the link to the about page
        $response = $this->get('/about');

        // Assert that the response status code is 200
        $response->assertStatus(200);

        // Assert that the current URL is the about page
        $response->assertSee('About us');
    }
}