<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_users()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('user.index'));

        $response->assertStatus(200)
            ->assertExactJsonStructure([
                'message',
                'data' => [
                    '*' => ['id', 'name', 'email', 'transactions_count', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_create_user()
    {
        $authUser = User::factory()->create();

        $userData = [
            'name' => 'Test User',
            'email' => 'amr@test.com',
            'password' => 'password',
        ];

        $response = $this->actingAs($authUser)->postJson(route('user.create'), $userData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User created',
                'data' => [
                    'name' => 'Test User',
                    'email' => 'amr@test.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'amr@test.com',
        ]);
    }

    public function test_can_update_user()
    {
        $authUser = User::factory()->create();

        $user = User::factory()->create();

        $updateData = [
            'name' => 'Test User',
            'email' => 'amr@test.com',
            'password' => 'password',
        ];

        $response = $this->actingAs($authUser)->putJson(route('user.update', $user->id), $updateData);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User updated',
                'data' => [
                    'name' => 'Test User',
                    'email' => 'amr@test.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Test User',
            'email' => 'amr@test.com',
        ]);
    }

    public function test_can_delete_user()
    {
        $authUser = User::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($authUser)->deleteJson(route('user.delete', $user->id));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted',
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
