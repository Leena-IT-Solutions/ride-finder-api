<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Drivers extends Component
{
    public $search = '';
    public $statusFilter = '';
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

    public function updatedStatusFilter()
    {
        $this->loadedCount = (int)$this->perPage;
    }

    public function loadMore()
    {
        $this->loadedCount += (int)$this->perPage;
    }

    public function verifyDriver($driverId)
    {
        $driver = User::find($driverId);
        if (!$driver || !in_array('driver', $driver->roles ?? [])) {
            session()->flash('error', 'Driver not found.');
            return;
        }

        $driver->driver_verification_status = 'verified';
        $driver->save();

        session()->flash('success', "Driver {$driver->name} has been verified successfully.");
    }

    public function rejectDriver($driverId)
    {
        $driver = User::find($driverId);
        if (!$driver || !in_array('driver', $driver->roles ?? [])) {
            session()->flash('error', 'Driver not found.');
            return;
        }

        $driver->driver_verification_status = 'rejected';
        $driver->save();

        session()->flash('success', "Driver {$driver->name}'s verification has been rejected.");
    }

    public function render()
    {
        $query = User::whereJsonContains('roles', 'driver');

        // Filter by status
        if ($this->statusFilter) {
            $query->where('driver_verification_status', $this->statusFilter);
        }

        // Search by Name, Email, or Mobile Number
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
            });
        }

        $totalMatches = $query->count();

        $drivers = $query->orderBy('created_at', 'desc')
                        ->limit($this->loadedCount)
                        ->get();

        return view('livewire.admin.drivers', [
            'drivers' => $drivers,
            'totalMatches' => $totalMatches,
            'hasMore' => $totalMatches > count($drivers)
        ])->layout('components.layouts.app', ['title' => 'Drivers Verification - RideFinder']);
    }
}
