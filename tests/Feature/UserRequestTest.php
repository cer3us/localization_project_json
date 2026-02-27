<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    // use RefreshDatabase; // Ensures a clean database for each test

    public function test_list_users()
    {
        $user = User::factory()->create();

        $userTestJson = [
            'id' => $user->id,
            'name' => $user->name
        ];

        $response = $this->actingAs($user, 'sanctum')  // authenticate using session cookie
            ->get(route('users.list'));

        //to test response code:
        $response->assertStatus(200);

        //to test json structure: 
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                // 'type',
                // 'companyName'
            ]
        ]);

        //checks if the json response contains a segment:  
        $response->assertJsonFragment($userTestJson);
    }

    public function test_add_account()
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'accountType' => 'individual',
            'password' => [
                'value' => '123123123',
                'confirmation' => '123123123'
            ]
        ];
        $response = $this->post(route('account.create'), $data);

        $response->assertStatus(201);
        //or
        $response->assertCreated();

        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'email',
                'account_type',
                'company_name',
                'updated_at',
                'created_at'
            ]
        ]);

        //checks if the created account is found in the db:
        $this->assertDatabaseHas('users', [
            'id' => $response->json('data.id'),
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        //returns the original response from the api:
        dd($response->json());
    }
}
