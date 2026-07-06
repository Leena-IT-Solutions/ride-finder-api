<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Stops extends Component
{
    public $search = '';
    public $typeFilter = '';
    public $perPage = 5;
    public $loadedCount;

    // CRUD properties
    public $stopId = null;
    public $name = '';
    public $type = 'bus';
    public $city = '';
    public $latitude = '';
    public $longitude = '';
    public $status = 'active';

    // Modal state flags
    public $isOpen = false;
    public $isDeleteOpen = false;
    public $deletingStopId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:bus,auto,taxi,parking',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status' => 'required|in:active,inactive,maintenance',
        ];
    }

    public function mount()
    {
        $this->loadedCount = (int)$this->perPage;
    }

    public function create()
    {
        $this->resetValidation();
        $this->stopId = null;
        $this->name = '';
        $this->type = 'bus';
        $this->city = '';
        $this->latitude = '';
        $this->longitude = '';
        $this->status = 'active';
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $stop = \App\Models\Stop::find($id);
        if (!$stop) {
            session()->flash('error', 'Stop location not found.');
            return;
        }

        $this->stopId = $stop->id;
        $this->name = $stop->name;
        $this->type = $stop->type;
        $this->city = $stop->city;
        $this->latitude = $stop->latitude;
        $this->longitude = $stop->longitude;
        $this->status = $stop->status;
        $this->isOpen = true;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->stopId) {
            $stop = \App\Models\Stop::find($this->stopId);
            if ($stop) {
                $stop->update($validatedData);
                session()->flash('success', 'Stop location updated successfully.');
            } else {
                session()->flash('error', 'Stop location not found.');
            }
        } else {
            \App\Models\Stop::create($validatedData);
            session()->flash('success', 'Stop location created successfully.');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deletingStopId = $id;
        $this->isDeleteOpen = true;
    }

    public function delete()
    {
        if ($this->deletingStopId) {
            $stop = \App\Models\Stop::find($this->deletingStopId);
            if ($stop) {
                $stop->delete();
                session()->flash('success', 'Stop location deleted successfully.');
            } else {
                session()->flash('error', 'Stop location not found.');
            }
        }

        $this->isDeleteOpen = false;
        $this->deletingStopId = null;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetValidation();
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
