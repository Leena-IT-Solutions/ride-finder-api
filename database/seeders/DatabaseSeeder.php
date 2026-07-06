<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed Sandeep Rathod with all roles
        User::factory()->create([
            'name' => 'Sandeep Rathod',
            'email' => 'sandeep198558@yahoo.com',
            'mobile_number' => '9664588677',
            'roles' => ['admin', 'manager', 'driver', 'user'],
            'password' => Hash::make('password'),
            'latitude' => 12.971598,
            'longitude' => 77.594566,
        ]);

        // Seed dedicated Manager User for testing
        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@ridefinder.com',
            'mobile_number' => '9999999999',
            'roles' => ['manager'],
            'password' => Hash::make('password'),
            'latitude' => 12.972000,
            'longitude' => 77.595000,
        ]);

        // Seed Stop locations around Sandeep's location in Bengaluru
        Stop::create([
            'name' => 'Kranthiveera Sangolli Rayanna Railway Station Bus Stop',
            'type' => 'bus',
            'city' => 'Bengaluru',
            'latitude' => 12.974598,
            'longitude' => 77.590566,
            'status' => 'active',
        ]);

        Stop::create([
            'name' => 'Cubbon Park Auto Stand',
            'type' => 'auto',
            'city' => 'Bengaluru',
            'latitude' => 12.975598,
            'longitude' => 77.597566,
            'status' => 'active',
        ]);

        Stop::create([
            'name' => 'MG Road Taxi Stand',
            'type' => 'taxi',
            'city' => 'Bengaluru',
            'latitude' => 12.968598,
            'longitude' => 77.591566,
            'status' => 'active',
        ]);

        Stop::create([
            'name' => 'UB City Parking Zone',
            'type' => 'parking',
            'city' => 'Bengaluru',
            'latitude' => 12.973598,
            'longitude' => 77.592566,
            'status' => 'active',
        ]);
    }
}
