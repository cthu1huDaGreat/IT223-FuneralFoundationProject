<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function changePassword(Request $request)
{
    // 1. Manual Validation
    $validator = Validator::make($request->all(), [
        'currentPassword' => 'required',
        'newPassword'     => 'required|min:8|confirmed', 
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // 2. Get user_id from session
    $userId = Session::get('user_id');

    // 3. Fetch user record using raw DB query
    $user = DB::table('users')->where('user_id', $userId)->first();

    if (!$user) {
        return back()->withErrors(['auth' => 'User not found or not logged in']);
    }

    // 4. Verify current password
    if (!Hash::check($request->currentPassword, $user->password)) {
        return back()->withErrors(['currentPassword' => 'Current password is incorrect']);
    }

    try {
        // 5. Update password using Stored Procedure
        DB::statement('CALL UpdateUserPassword(?, ?)', [
            $userId, 
            Hash::make($request->newPassword)
        ]);

        return back()->with('success', 'Password changed successfully!');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Could not update password.']);
    }
}
}
