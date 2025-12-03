<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    // Register routes
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login routes  
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Authenticated routes (logged in)
Route::middleware('auth')->group(function () {
    // Logout route
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
