<?php

namespace Database\Seeders;

use App\Models\User;
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
            'roles' => ['admin', 'driver', 'user'],
            'password' => Hash::make('password'),
            'latitude' => 12.971598,
            'longitude' => 77.594566,
        ]);
    }
}
