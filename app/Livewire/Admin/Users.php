<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $search = '';
    public $roleFilter = '';
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

    public function updatedRoleFilter()
    {
        $this->loadedCount = (int)$this->perPage;
    }

    public function loadMore()
    {
        $this->loadedCount += (int)$this->perPage;
    }

    public function render()
    {
        $query = User::query();

        // 1. Filter by role
        if ($this->roleFilter) {
            $query->whereJsonContains('roles', $this->roleFilter);
        }

        // 2. Search by Name, Email, or Mobile Number
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
            });
        }

        $totalMatches = $query->count();

        $users = $query->orderBy('created_at', 'desc')
                      ->limit($this->loadedCount)
                      ->get();

        return view('livewire.admin.users', [
            'users' => $users,
            'totalMatches' => $totalMatches,
            'hasMore' => $totalMatches > count($users)
        ])->layout('components.layouts.app', ['title' => 'Users - RideFinder']);
    }
}
