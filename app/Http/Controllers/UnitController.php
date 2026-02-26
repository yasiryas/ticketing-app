<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('unit.index', [
        //     'units' => Unit::all(),
        // ]);
        return view('unit.index');
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
        $request->validate([
            'name' => 'required|unique:units,name|string|max:255',
            'description' => 'nullable|string',
        ]);

        Unit::create($request->only('name', 'description'));

        // Check if AJAX request
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unit created successfully']);
        }

        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        // Check if AJAX request
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Unit deleted successfully']);
        }

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }

    public function data(Request $request)
    {
        $query = Unit::query();


        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Get per_page parameter (default 10)
        $perPage = $request->per_page ?? 10;

        // Paginate the results
        $units = $query->paginate($perPage);

        return response()->json([
            'data' => $units->items(),
            'meta' => [
                'current_page' => $units->currentPage(),
                'from' => $units->firstItem(),
                'to' => $units->lastItem(),
                'last_page' => $units->lastPage(),
                'path' => $units->path(),
                'total' => $units->total(),
            ]
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'name')->ignore($unit->id)
            ],
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Ups, nama unit sudah digunakan. Silakan pilih nama lain.',
        ]);

        $unit->update($request->only('name', 'description'));

        return response()->json([
            'message' => 'Unit updated successfully'
        ]);
    }


    public function destroyUnit(Unit $unit)
    {
        $unit->delete();
        return response()->json(['message' => 'Unit deleted successfully']);
    }
}
