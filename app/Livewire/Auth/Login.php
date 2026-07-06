<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $login_input = ''; // can be mobile number or email
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'login_input' => 'required|string',
        'password' => 'required|string',
    ];

    public function login()
    {
        $this->validate();

        // Determine if input is email or mobile number
        $fieldType = filter_var($this->login_input, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        // Check if user exists
        $user = User::where($fieldType, $this->login_input)->first();

        if (!$user) {
            $this->addError('login_input', 'These credentials do not match our records.');
            return;
        }

        // Attempt login
        if (Auth::attempt([$fieldType => $this->login_input, 'password' => $this->password], $this->remember)) {
            // Check if the user is an admin or manager
            if (!$user->hasAdminAccess()) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                session()->flash('error', 'Access Denied: Only Admin or Manager roles are permitted to access this panel.');
                return;
            }

            // Regenerate session
            session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        $this->addError('password', 'Incorrect password.');
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.app', ['title' => 'Login - RideFinder']);
    }
}
