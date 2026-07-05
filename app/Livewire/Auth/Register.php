<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $mobile_number = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:users,mobile_number|regex:/^[0-9]{10,15}$/',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    protected function messages(): array
    {
        return [
            'mobile_number.regex' => 'The mobile number must be between 10 and 15 digits and contain only numbers.',
        ];
    }

    public function register()
    {
        $this->validate();

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'mobile_number' => $this->mobile_number,
            'email' => !empty($this->email) ? $this->email : null,
            'roles' => ['user'], // default role is always User
            'password' => Hash::make($this->password),
        ]);

        if ($user->isAdmin()) {
            auth()->login($user);
            return redirect()->route('admin.dashboard');
        }

        // If the registered user is a driver or user, redirect to login showing that access is restricted to Admins
        return redirect()->route('login')->with('success', "Registration successful for {$user->name}! Please log in via the mobile application, as web access is restricted to Admins.");
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.app', ['title' => 'Register - RideFinder']);
    }
}
