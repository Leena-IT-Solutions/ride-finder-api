<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard (if admin) or login
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        auth()->logout();
    }
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Admin-only Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/admin/users', \App\Livewire\Admin\Users::class)->name('admin.users');
    Route::get('/admin/drivers', \App\Livewire\Admin\Drivers::class)->name('admin.drivers');
    Route::get('/admin/vehicles', \App\Livewire\Admin\Vehicles::class)->name('admin.vehicles');
    Route::get('/admin/stops', \App\Livewire\Admin\Stops::class)->name('admin.stops');
    Route::get('/admin/settings', \App\Livewire\Admin\Settings::class)->name('admin.settings');
});

