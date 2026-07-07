<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

// Show landing page on root or redirect admin to dashboard
Route::get('/', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
});

// Privacy Policy page
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
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

