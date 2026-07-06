<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Public auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/config', [AuthController::class, 'getConfig']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::put('/user', [AuthController::class, 'updateProfile']);
    Route::put('/user/password', [AuthController::class, 'updatePassword']);
    Route::put('/user/location', [AuthController::class, 'updateLocation']);
    Route::put('/user/online-status', [AuthController::class, 'updateOnlineStatus']);
    Route::delete('/user', [AuthController::class, 'deleteAccount']);
    Route::get('/stops', [AuthController::class, 'getStops']);
    Route::post('/stops', [AuthController::class, 'storeStop']);
    Route::get('/drivers/active', [AuthController::class, 'getActiveDrivers']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Vehicle management routes
    Route::post('/user/vehicles', [AuthController::class, 'addVehicle']);
    Route::post('/user/vehicles/{id}/select', [AuthController::class, 'selectVehicle']);
});
