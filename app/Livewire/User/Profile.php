<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $name = '';
    public string $email = '';
    public string $mobile_number = '';

    // Password fields
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    // Delete account field
    public string $confirm_delete_password = '';

    public function mount(): void
    {
        $user = auth()->user();
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->mobile_number = $user->mobile_number ?? '';
        }
    }

    public function updateProfile(): void
    {
        $user = auth()->user();

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
        ]);

        session()->flash('profile_success', 'Profile details updated successfully!');
    }

    public function updatePassword(): void
    {
        $user = auth()->user();

        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password you entered is incorrect.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('password_success', 'Password updated successfully!');
    }

    public function deleteAccount(): void
    {
        $user = auth()->user();

        $this->validate([
            'confirm_delete_password' => 'required|string',
        ]);

        if (!Hash::check($this->confirm_delete_password, $user->password)) {
            $this->addError('confirm_delete_password', 'The password you entered is incorrect.');
            return;
        }

        // Delete user relations and user
        Log::warning('User Account Deleted via Web Profile', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile_number' => $user->mobile_number,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        $user->vehicles()->delete();
        $user->delete();

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        session()->flash('welcome_message', 'Your account has been deleted successfully.');
        
        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.profile')
            ->layout('components.layouts.app', ['title' => 'My Profile - Ride Finder']);
    }
}
