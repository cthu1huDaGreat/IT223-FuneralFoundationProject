<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function changePassword(Request $request)
    {
        //Validate input
        $request->validate([
            'currentPassword'          => 'required',
            'newPassword'              => 'required|min:8|confirmed', 
        ]);

        //Get user_id from session
        $userId = Session::get('user_id');

        //Fetch user record
        $user = DB::table('users')->where('user_id', $userId)->first();

        if (!$user) {
            return back()->withErrors(['auth' => 'User not found or not logged in']);
        }

        //Verify current password
        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->withErrors(['currentPassword' => 'Current password is incorrect']);
        }

        //Update password (hashed)
        DB::table('users')
            ->where('user_id', $userId)
            ->update(['password' => Hash::make($request->newPassword)]);

        return back()->with('success', 'Password changed successfully!');
    }
}
