<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getPendingRegistrations()
    {
        try {
            $pendingUsers = User::where('role_id', 0)
                ->select('user_id', 'fname', 'lname', 'email')
                ->get();

            return response()->json([
                'success' => true,
                'users' => $pendingUsers
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching users: ' . $e->getMessage()
            ], 500);
        }
    }

public function approveUser(Request $request)
{
    try {
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);
        $existingFund = DB::table('funeral_fund')->where('user_id', $userId)->first();
        
        if (!$existingFund) {
            DB::table('funeral_fund')->insert([
                'user_id' => $userId,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'User approved successfully and added to funeral fund'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error approving user: ' . $e->getMessage()
        ], 500);
    }
}

    public function deleteUser(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,user_id'
            ]);

            $deleted = User::where('user_id', $request->user_id)->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }
}