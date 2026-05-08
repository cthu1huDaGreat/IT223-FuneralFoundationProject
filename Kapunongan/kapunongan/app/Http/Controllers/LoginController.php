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
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);
    $results = DB::select("CALL GetUserByEmail(?)", [$credentials['email']]);
    $user = !empty($results) ? $results[0] : null;
    if ($user && Hash::check($credentials['password'], $user->password)) {

        Session::put('user_id', $user->user_id);
        Session::put('role_id', $user->role_id);
        Session::put('email', $user->email);

        switch ($user->role_id) {
            case 0:
                return redirect()->route('login')->with('error', 'Account not approved.');
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
    return back()->with('error', 'Invalid login credentials');
}

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
