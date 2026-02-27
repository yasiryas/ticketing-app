<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Ticket;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total = Ticket::count() ?: 1;

        $open = Ticket::where('status', 'open')->count();
        $in_progress =  Ticket::where('status', 'in_progress')->count();
        $closed = Ticket::where('status', 'closed')->count();

        // Get ticket count by unit (for chart)
        $unitStats = Unit::withCount('tickets')
            ->having('tickets_count', '>', 0)
            ->orderByDesc('tickets_count')
            ->get();

        // Get user's own tickets if not admin
        $userTickets = [];
        if (!Auth::user()->isAdmin()) {
            $userTickets = Ticket::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'total' => $total,
            'open' => $open,
            'in_progress' => $in_progress,
            'closed' => $closed,
            'latestTickets' => Ticket::with(['unit', 'user'])->latest()->take(5)->get(),
            'userTickets' => $userTickets,
            'unitStats' => $unitStats,
            'progress' => [
                'open' => round(($open / $total) * 100),
                'in_progress' => round(($in_progress / $total) * 100),
                'closed' => round(($closed / $total) * 100),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
