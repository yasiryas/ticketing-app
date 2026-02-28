<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct() {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'Ups, email sudah digunakan. Silakan gunakan email lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8',
        ], [
            'email.unique' => 'Ups, email sudah digunakan. Silakan gunakan email lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Update password only if provided
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Tidak bisa menghapus akun sendiri'], 422);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Get data for DataTables.
     */
    public function data(Request $request)
    {
        $query = User::query()->select(['id', 'name', 'email', 'role', 'created_at']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->per_page ?? 10;
        $users = $query->paginate($perPage);

        return response()->json([
            'data' => $users->items(),
            'meta' => [
                'current_page' => $users->currentPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
                'last_page' => $users->lastPage(),
                'path' => $users->path(),
                'total' => $users->total(),
            ]
        ]);
    }
}
