<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    // use RefreshDatabase;

    public function test_list_users()
    {
        $user = User::factory()->create();

        $userTestJson = [
            'id' => $user->id,
            'name' => $user->name
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->get(route('users.list'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'type',
                'companyName'
            ]
        ]);

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

        $this->assertDatabaseHas('users', [
            'id' => $response->json('data.id'),
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        dd($response->json());
    }
}
