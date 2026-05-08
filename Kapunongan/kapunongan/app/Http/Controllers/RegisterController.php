<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'lname' => 'required|string|max:50',
            'fname' => 'required|string|max:50',
            'mi' => 'nullable|string|max:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $creatorRole = Auth::check() ? Auth::user()->role_id : null;
        DB::statement("CALL RegisterUser(?, ?, ?, ?, ?, ?)", [
            $validated['lname'],
            $validated['fname'],
            $validated['mi'] ?? null,
            $validated['email'],
            Hash::make($validated['password']),
            $creatorRole
        ]);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully via Procedure!'
            ]);
        }
        return redirect()->back()->with('success', 'User registered successfully!');
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
}