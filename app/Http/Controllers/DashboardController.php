<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with ticket statistics.
     */
    public function index()
    {
        $totalTickets = Ticket::count(); // Avoid division by zero

        $total = $totalTickets > 0 ? $totalTickets : 1; // Ensure total is at least 1 to prevent division by zero

        $open = Ticket::where('status', 'open')->count();
        $in_progress = Ticket::where('status', 'in_progress')->count();
        $closed = Ticket::where('status', 'closed')->count();

        // Get ticket count by unit (for chart)
        $unitStats = Unit::withCount('tickets')
            ->having('tickets_count', '>', 0)
            ->orderByDesc('tickets_count')
            ->get();

        // Get latest tickets with relationships for the table
        $latestTickets = Ticket::with(['unit', 'user'])->latest()->take(5)->get();

        // Data untuk dikirim ke view
        $data = [
            'title' => 'Dashboard',
            'total' => $total,
            'totalTickets' => $totalTickets, // Kirim juga nilai asli
            'open' => $open,
            'in_progress' => $in_progress,
            'closed' => $closed,
            'latestTickets' => $latestTickets,
            'unitStats' => $unitStats,
            'currentUserId' => Auth::id(),
        ];

        // Hitung persentase hanya jika ada tiket
        if ($totalTickets > 0) {
            $data['progress'] = [
                'open' => round(($open / $totalTickets) * 100),
                'in_progress' => round(($in_progress / $totalTickets) * 100),
                'closed' => round(($closed / $totalTickets) * 100),
            ];
        } else {
            $data['progress'] = [
                'open' => 0,
                'in_progress' => 0,
                'closed' => 0,
            ];
        }

        // Cek apakah user login sebelum memanggil isAdmin()
        $data['isAdmin'] = Auth::check() ? Auth::user()->isAdmin() : false;

        return view('dashboard', $data);
    }
}
