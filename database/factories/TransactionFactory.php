<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_amount' => fake()->numberBetween(10, 10000),
            'transaction_date' => fake()->dateTime(),
            'user_id' => 1,
            'location_id' => 1
        ];
    }
}
