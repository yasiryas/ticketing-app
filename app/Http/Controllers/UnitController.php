<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('unit.index', [
            'units' => Unit::all(),
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
        $request->validate([
            'name' => 'required|unique|string|max:255',
            'description' => 'nullable|string',
        ]);

        Unit::create($request->only('name', 'description'));

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

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }

    public function data(Request $request)
    {
        $search = $request->get('search');

        $units = Unit::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return response()->json($units);
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
