<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $total = \App\Models\Ticket::count() ?: 1;
    $open = \App\Models\Ticket::where('status', 'open')->count();
    $in_progress = \App\Models\Ticket::where('status', 'in_progress')->count();
    $closed = \App\Models\Ticket::where('status', 'closed')->count();

    $tickets = \App\Models\Ticket::with(['unit', 'user'])->latest()->take(50)->get();

    return view('welcome', [
        'total' => $total,
        'open' => $open,
        'in_progress' => $in_progress,
        'closed' => $closed,
        'tickets' => $tickets,
        'progress' => [
            'open' => round(($open / $total) * 100),
            'in_progress' => round(($in_progress / $total) * 100),
            'closed' => round(($closed / $total) * 100),
        ]
    ]);
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
});

require __DIR__ . '/auth.php';
