<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('page.index');
    }

    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Get user by email
        $user = DB::table('users')
            ->where('email', $credentials['email'])
            ->first();

        // Check if user exists and password matches hashed password
        if ($user && Hash::check($credentials['password'], $user->password)) {

            // Store values in session
            Session::put('user_id', $user->user_id);
            Session::put('role_id', $user->role_id);
            Session::put('email', $user->email);

            // Redirect based on role
            switch ($user->role_id) {
                 case 0:
                    return redirect()->route('login')->with('error', 'Your account is not yet Approved. Please contact admin.');
                case 1:
                    return redirect()->route('page.dashboard-member');
                case 2:
                    return redirect()->route('page.dashboard-treasurer');
                case 3:
                    return redirect()->route('page.dashboard-president');
                default:
                    return redirect()->route('login')->with('error', 'Role not recognized');
            }
        }

        // If login fails
        return back()->with('error', 'Invalid login credentials');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
