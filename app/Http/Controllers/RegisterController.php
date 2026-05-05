<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'lname' => 'required|string|max:50',
                'fname' => 'required|string|max:50',
                'mi' => 'nullable|string|max:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
            ]);

            // Determine role based on who is creating the account
            $creatorRole = Auth::check() ? Auth::user()->role_id : null;

            if ($creatorRole == 2 || $creatorRole == 3) {
                $assignedRole = 1;   // default to 1
            } else {
                $assignedRole = 0;   // default to 0
            }

            // Store user with hashed password
            User::create([
                'lname' => $validated['lname'],
                'fname' => $validated['fname'],
                'mi' => $validated['mi'] ?? null,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $assignedRole,
            ]);

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User registered successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'User registered successfully!');

        } catch (\Exception $e) {
            // Return JSON response for AJAX errors
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