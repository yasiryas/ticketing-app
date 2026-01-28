<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Ticket;
use Illuminate\Http\Request;

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

        return view('dashboard', [
            'title' => 'Dashboard',
            'total' => $total,
            'open' => $open,
            'in_progress' => $in_progress,
            'closed' => $closed,
            'latestTickets' => Ticket::latest()->take(5)->get(),
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
