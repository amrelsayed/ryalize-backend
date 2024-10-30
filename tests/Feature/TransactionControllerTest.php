<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_list_transactions()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create();

        Transaction::factory()->count(5)->create([
            "user_id" => $user->id,
            "location_id" => $location->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('transactions.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'amount', 'date', 'user', 'location'],
                ],
            ]);
    }

    public function test_can_filter_transactions_by_user_id()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create();

        Transaction::factory()->count(3)->create([
            'user_id' => $user->id,
            'location_id' => $location->id,
        ]);

        $user2 = User::factory()->create();
        $location2 = Location::factory()->create();

        Transaction::factory()->count(2)->create([
            'user_id' => $user2->id,
            'location_id' => $location2->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('transactions.index', ['user_id' => $user->id]));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_filter_transactions_by_amount_range()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create();

        Transaction::factory()->create(['user_id' => $user->id, 'location_id' => $location->id, 'transaction_amount' => 100]);
        Transaction::factory()->create(['user_id' => $user->id, 'location_id' => $location->id, 'transaction_amount' => 300]);
        Transaction::factory()->create(['user_id' => $user->id, 'location_id' => $location->id, 'transaction_amount' => 500]);

        $response = $this->actingAs($user)->getJson(route('transactions.index', [
            'amount_from' => 200,
            'amount_to' => 400,
        ]));

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_filter_transactions_by_date_range()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create();

        Transaction::factory()->create(['user_id' => $user->id, 'location_id' => $location->id, 'transaction_date' => '2023-01-01']);
        Transaction::factory()->create(['user_id' => $user->id, 'location_id' => $location->id, 'transaction_date' => '2023-06-15']);
        Transaction::factory()->create(['user_id' => $user->id, 'location_id' => $location->id, 'transaction_date' => '2023-12-31']);

        $response = $this->actingAs($user)->getJson(route('transactions.index', [
            'date_from' => '2023-01-01',
            'date_to' => '2023-06-30',
        ]));

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_can_filter_transactions_by_location_id()
    {
        $user = User::factory()->create();
        $location = Location::factory()->create();
        $location2 = Location::factory()->create();

        Transaction::factory()->count(3)->create(['user_id' => $user->id, 'location_id' => $location->id]);
        Transaction::factory()->count(2)->create(['user_id' => $user->id, 'location_id' => $location2->id]);

        $response = $this->actingAs($user)->getJson(route('transactions.index', ['location_id' => $location->id]));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}
