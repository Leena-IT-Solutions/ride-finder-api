<?php

namespace App\Livewire\Admin;

use App\Models\Vehicle;
use Livewire\Component;

class Vehicles extends Component
{
    public $search = '';
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

    public function loadMore()
    {
        $this->loadedCount += (int)$this->perPage;
    }

    public function render()
    {
        $query = Vehicle::with('user');

        // Search by Make, Model, Number Plate, or Owner Name
        if ($this->search) {
            $query->where(function($q) {
                $q->where('make', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%')
                  ->orWhere('number_plate', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $totalMatches = $query->count();

        $vehicles = $query->orderBy('created_at', 'desc')
                          ->limit($this->loadedCount)
                          ->get();

        return view('livewire.admin.vehicles', [
            'vehicles' => $vehicles,
            'totalMatches' => $totalMatches,
            'hasMore' => $totalMatches > count($vehicles)
        ])->layout('components.layouts.app', ['title' => 'Vehicles - RideFinder']);
    }
}
