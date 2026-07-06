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

    // Modal state properties
    public $activeModalPhoto = null;
    public $activeModalTitle = '';
    public $isPhotoModalOpen = false;

    public function openPhotoModal($photoUrl, $title)
    {
        $this->activeModalPhoto = $photoUrl;
        $this->activeModalTitle = $title;
        $this->isPhotoModalOpen = true;
    }

    public function closePhotoModal()
    {
        $this->isPhotoModalOpen = false;
        $this->activeModalPhoto = null;
        $this->activeModalTitle = '';
    }

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

    /**
     * Toggle a specific role for a user.
     */
    public function toggleRole($userId, $role)
    {
        $user = User::find($userId);
        if (!$user) {
            return;
        }

        // Prevent self-revoking admin role
        if ($user->id == auth()->id() && $role === 'admin') {
            session()->flash('error', 'You cannot revoke your own Administrator role to avoid lockout.');
            return;
        }

        $roles = $user->roles ?? [];
        if (in_array($role, $roles)) {
            // Revoke
            $roles = array_values(array_filter($roles, fn($r) => $r !== $role));
        } else {
            // Assign
            $roles[] = $role;
        }

        $user->roles = $roles;
        $user->save();

        session()->flash('success', "Roles updated successfully for {$user->name}.");
    }
}
