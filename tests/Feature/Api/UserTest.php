<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;  // Ensures the database is refreshed before each test

    public function test_register_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'confirmpassword' => 'password123',
        ]);

        // Debugging assertion for response content
        $response->dump();  // This will dump the response content for debugging

        $response->assertStatus(201) 
                ->assertJson([
                    'message' => 'User registered successfully!',
                ])
                ->assertJsonStructure([
                    'user' => ['id', 'name', 'email'],
                ]);
    }


    public function test_login_user()
    {
        // First, create a user to log in
        $user = \App\Models\User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)  // Check for HTTP status code 200 (OK)
                ->assertJsonStructure([
                    'message',
                    'token',
                ]);
    }

    public function test_fund_wallet()
    {
        // First, create a user and log them in
        $user = \App\Models\User::factory()->create();
        $token = $this->actingAs($user)->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',  // Make sure to set the correct password
        ])->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/wallet/fund', [
            'amount' => 100,
        ]);

        $response->assertStatus(200)  // Check for HTTP status code 200 (OK)
                ->assertJson([
                    'message' => 'Wallet funded successfully!',
                ])
                ->assertJsonStructure([
                    'wallet' => ['id', 'user_id', 'balance', 'created_at', 'updated_at'],
                ]);
    }

    public function test_purchase_airtime()
    {
        // First, create a user and fund their wallet
        $user = \App\Models\User::factory()->create();
        $wallet = \App\Models\Wallet::create(['user_id' => $user->id, 'balance' => 200]);

        $token = $this->actingAs($user)->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->json('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/purchase/airtime', [
            'amount' => 50,
        ]);

        $response->assertStatus(200)  // Check for HTTP status code 200 (OK)
                ->assertJson([
                    'message' => 'Airtime purchased successfully!',
                ])
                ->assertJsonStructure([
                    'transaction' => ['id', 'user_id', 'wallet_id', 'type', 'amount', 'description', 'created_at', 'updated_at'],
                ]);
    }



}

