<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function updateMember(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id'  => 'required|exists:users,user_id',
        'fname'    => 'required|string|max:50',
        'lname'    => 'required|string|max:50',
        'mi'       => 'nullable|string|max:3',
        'email'    => 'required|email|unique:users,email,' . $request->user_id . ',user_id',
        'role_id'  => 'required|in:1,2,3',
        'password' => 'nullable|min:6|confirmed'
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
    }

    try {
        $hashedPassword = $request->filled('password') ? Hash::make($request->password) : null;
        DB::statement('CALL UpdateMember(?, ?, ?, ?, ?, ?, ?)', [
            $request->user_id,
            $request->fname,
            $request->lname,
            $request->mi,
            $request->email,
            $request->role_id,
            $hashedPassword
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully!'
        ]);

    } catch (\Exception $e) {
        Log::error('Update Member Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server Error'], 500);
    }
}

public function getMembers()
    {
        try {
            $members = DB::table('members_list_view')->get();
            return response()->json([
                'success' => true, 
                'members' => $members
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

public function getRoles()
{
    $roles = DB::select('CALL GetActiveRoles()');

    return response()->json([
        'success' => true, 
        'roles' => $roles
    ]);
}

public function deleteMember(Request $request)
{
    DB::statement('CALL DeleteMemberByID(?)', [$request->user_id]);
    return response()->json([
        'success' => true, 
        'message' => 'Member deleted successfully!'
    ]);
}

public function getMembersCount()
{
    $result = DB::select('CALL GetTotalMembersCount()');
    $count = $result[0]->total_count;
    return response()->json([
        'success' => true, 
        'count' => $count
    ]);
}
}