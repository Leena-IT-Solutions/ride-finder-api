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

        // Seed Sandeep Rathod if doesn't exist
        User::firstOrCreate(
            ['email' => 'sandeep198558@gmail.com'],
            [
                'name' => 'Sandeep Rathod',
                'mobile_number' => '9664588677',
                'roles' => ['admin', 'manager', 'driver', 'user'],
                'password' => Hash::make('password'),
                'latitude' => 12.971598,
                'longitude' => 77.594566,
            ]
        );

        // Seed Leena Adam if doesn't exist
        User::firstOrCreate(
            ['email' => 'leenaadam28@gmail.com'],
            [
                'name' => 'Leena Adam',
                'mobile_number' => '9769409405',
                'roles' => ['admin', 'manager', 'user'],
                'password' => Hash::make('password'),
            ]
        );

        // Seed Stop locations if they don't exist
        Stop::firstOrCreate(
            ['name' => 'Sarvodaya Nagar Main Gate'],
            [
                'type' => 'auto',
                'city' => 'Ambernath',
                'latitude' => 19.189387605307818,
                'longitude' => 73.21953875219381,
                'status' => 'active',
            ]
        );

        Stop::firstOrCreate(
            ['name' => 'Sarvodaya Nagar, Phase 3'],
            [
                'type' => 'auto',
                'city' => 'Ambernath',
                'latitude' => 19.188054600497303,
                'longitude' => 73.2208181397075,
                'status' => 'active',
            ]
        );

        Stop::firstOrCreate(
            ['name' => 'Orchid, Sarvodaya Nagar'],
            [
                'type' => 'auto',
                'city' => 'Ambernath',
                'latitude' => 19.189818686453105,
                'longitude' => 73.2207734974165,
                'status' => 'active',
            ]
        );
    }
}
