<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Livewire\Livewire;
use App\Models\User;
use App\Models\Stop;

class StopsTest extends TestCase
{
    public function test_stops_page_renders_and_filters_stops(): void
    {
        // Seed test data
        $admin = User::factory()->create(['roles' => ['admin']]);
        
        $busStop = Stop::create([
            'name' => 'Bangalore Bus Stop',
            'type' => 'bus',
            'city' => 'Bengaluru',
            'latitude' => 12.97,
            'longitude' => 77.59,
            'status' => 'active',
        ]);

        $autoStand = Stop::create([
            'name' => 'Indiranagar Auto Stand',
            'type' => 'auto',
            'city' => 'Bengaluru',
            'latitude' => 12.98,
            'longitude' => 77.60,
            'status' => 'active',
        ]);

        // Access the component acting as the admin
        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\Stops::class)
            ->set('perPage', 10)
            // 1. Assert stops are displayed
            ->assertSee('Bangalore Bus Stop')
            ->assertSee('Indiranagar Auto Stand')
            // 2. Test search filter
            ->set('search', 'Indiranagar')
            ->assertSee('Indiranagar Auto Stand')
            ->assertDontSee('Bangalore Bus Stop')
            // 3. Test type filter
            ->set('search', '')
            ->set('typeFilter', 'bus')
            ->assertSee('Bangalore Bus Stop')
            ->assertDontSee('Indiranagar Auto Stand');
    }
}
