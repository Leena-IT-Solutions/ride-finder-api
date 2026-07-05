<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Stops extends Component
{
    public $search = '';
    public $typeFilter = '';
    public $perPage = 5;
    public $loadedCount;

    public function mount()
    {
        $this->loadedCount = (int)$this->perPage;
    }

    public function updatedPerPage($value)
    {
        $this->loadedCount = (int)$value;
    }

    public function updatedSearch()
    {
        $this->loadedCount = (int)$this->perPage;
    }

    public function updatedTypeFilter()
    {
        $this->loadedCount = (int)$this->perPage;
    }

    public function loadMore()
    {
        $this->loadedCount += (int)$this->perPage;
    }

    public function render()
    {
        // Mock data for vehicle stops and parking locations with City info
        $stopsData = collect([
            [
                'id' => 1,
                'name' => 'Koramangala Sony World Junction Bus Stop',
                'type' => 'Bus Stop',
                'city' => 'Bengaluru',
                'latitude' => 12.9348,
                'longitude' => 77.6256,
                'active_vehicles' => 12,
            ],
            [
                'id' => 2,
                'name' => 'Indiranagar Metro Station Auto Stand',
                'type' => 'Auto Stand',
                'city' => 'Bengaluru',
                'latitude' => 12.9784,
                'longitude' => 77.6408,
                'active_vehicles' => 8,
            ],
            [
                'id' => 3,
                'name' => 'MG Road Boulevard Bus Station',
                'type' => 'Bus Stop',
                'city' => 'Bengaluru',
                'latitude' => 12.9756,
                'longitude' => 77.6068,
                'active_vehicles' => 15,
            ],
            [
                'id' => 4,
                'name' => 'Kempegowda International Airport Taxi Stand',
                'type' => 'Taxi Stand',
                'city' => 'Devenahalli',
                'latitude' => 13.1986,
                'longitude' => 77.7066,
                'active_vehicles' => 42,
            ],
            [
                'id' => 5,
                'name' => 'Phoenix Marketcity Multilevel Parking',
                'type' => 'Parking Location',
                'city' => 'Mumbai',
                'latitude' => 12.9977,
                'longitude' => 77.6964,
                'active_vehicles' => 120,
            ],
        ]);

        $stops = $stopsData;

        // Apply Search
        if ($this->search) {
            $searchTerm = strtolower($this->search);
            $stops = $stops->filter(function ($stop) use ($searchTerm) {
                return str_contains(strtolower($stop['name']), $searchTerm) ||
                       str_contains(strtolower($stop['type']), $searchTerm) ||
                       str_contains(strtolower($stop['city']), $searchTerm);
            });
        }

        // Apply Type Filter
        if ($this->typeFilter) {
            $stops = $stops->filter(function ($stop) {
                return $stop['type'] === $this->typeFilter;
            });
        }

        $totalMatches = $stops->count();
        $stops = $stops->slice(0, $this->loadedCount);

        return view('livewire.admin.stops', [
            'stops' => $stops,
            'totalMatches' => $totalMatches,
            'hasMore' => $totalMatches > $stops->count()
        ])->layout('components.layouts.app', ['title' => 'Stops - RideFinder']);
    }
}
