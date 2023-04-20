<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_can_login_with_valid_credentials()
    {
        // Create a new user
        $user = User::create([
            'name' => 'Joe',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Test login functionality
        $response = $this->actingAs($user)->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Arrange
        $user = User::create([
            'name' => 'Joe',
            'email' => 'user@example',
            'password' => bcrypt('password'),
        ]);

        // Act
        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'wrong_password',
        ]);

        // Assert
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        // Arrange
        $user = User::create([
            'name' => 'Joe',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user); // Authenticate the user

        // Act
        $response = $this->post('/logout');

        // Assert
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
