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
        $query = \App\Models\Stop::query();

        // Apply Search
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('city', 'like', $searchTerm)
                  ->orWhere('type', 'like', $searchTerm);
            });
        }

        // Apply Type Filter
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        $totalMatches = $query->count();
        $stops = $query->take($this->loadedCount)->get();

        return view('livewire.admin.stops', [
            'stops' => $stops,
            'totalMatches' => $totalMatches,
            'hasMore' => $totalMatches > $stops->count()
        ])->layout('components.layouts.app', ['title' => 'Stops - RideFinder']);
    }
}
