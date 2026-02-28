<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $total = Ticket::count() ?: 1;
        $open = Ticket::where('status', 'open')->count();
        $in_progress = Ticket::where('status', 'in_progress')->count();
        $closed = Ticket::where('status', 'closed')->count();

        $tickets = Ticket::with(['unit', 'user'])->latest()->take(50)->get();

        $data = [
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
        ];

        return view('welcome', $data);
    }
}
