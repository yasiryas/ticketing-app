<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,progress,closed',
            'unit_id' => 'nullable|exists:units,id',
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'unit_id' => $request->unit_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket Berhasil dibuat.');
    }


    public function data(Request $request)
    {
        return response()->json([
            'open' => Ticket::with('unit')->where('status', 'open')->latest()->get(),
            'progress' => Ticket::with('unit')->where('status', 'in_progress')->latest()->get(),
            'closed' => Ticket::with('unit')->where('status', 'closed')->latest()->get(),
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('replies.user');

        return view('tickets.show', [
            'title' => 'Detail Ticket',
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'unit_id' => 'nullable|exists:units,id',
        ]);

        $ticket->update($request->only(['title', 'description', 'status', 'unit_id']));

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Ticket updated successfully']);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Ticket deleted successfully']);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully');
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $ticket->replies()->create([
            'user_id' => Auth::id(),
            'reply' => $request->input('reply'),
        ]);

        if (Auth::user()->role === 'admin' && $ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Reply added successfully.');
    }
}
