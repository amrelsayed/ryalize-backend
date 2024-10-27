<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Location::factory()->count(10)->create();

        for ($i = 0; $i < 10; $i++) {
            Transaction::factory()->count(10000)->create([
                'user_id' => $user->id,
                'location_id' => $i + 1,
            ]);
        }

    }
}
