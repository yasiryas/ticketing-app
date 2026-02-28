<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::controller(WelcomeController::class)->group(function () {
    Route::get('/', 'index')->name('welcome');
});


// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tickets
    Route::get('/tickets-data', [TicketController::class, 'data'])->name('tickets.data');
    Route::post('tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::patch('tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::resource('tickets', TicketController::class);

    // Units (admin only)
    Route::get('/units-data', [UnitController::class, 'data'])->name('units.data');
    Route::resource('units', UnitController::class);

    // Users (admin only)
    Route::get('/users-data', [UserController::class, 'data'])->name('users.data');
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';
