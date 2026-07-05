<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Fetch stats
        $stats = [
            'total_users' => User::whereJsonContains('roles', 'user')->count(),
            'total_drivers' => User::whereJsonContains('roles', 'driver')->count(),
            'total_admins' => User::whereJsonContains('roles', 'admin')->count(),
            'bus_stops' => 2,
            'auto_stops' => 1,
            'taxi_stands' => 1,
            'parkings' => 1,
        ];

        return view('livewire.admin.dashboard', compact('stats'))
            ->layout('components.layouts.app', ['title' => 'Admin Dashboard - RideFinder']);
    }
}
