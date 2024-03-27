<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'oussamaazrour@gmail.com',
            'password' => 'Oussama123',
        ]);

        $response->assertStatus(200);
    }

    public function testRegisterPage()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Youssef',
            'email' => 'youssefamine@gmail.com',
            'password' => 'Youssef@123',
        ]);
        $response->assertStatus(200);
    }

    public function testLogoutPage()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');
        $response->assertStatus(200);
    }
    
        
}