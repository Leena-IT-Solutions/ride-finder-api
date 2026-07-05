<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.app', ['title' => 'Portal Settings - RideFinder']);
    }
}
