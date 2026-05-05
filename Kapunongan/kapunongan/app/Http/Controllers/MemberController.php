<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function updateMember(Request $request)
    {
        try {
            // Log the incoming request
            Log::info('=== UPDATE MEMBER REQUEST ===');
            Log::info('All Request Data:', $request->all());
            Log::info('User ID: ' . $request->user_id);
            Log::info('============================');

            // Manually validate to see what's coming in
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,user_id',
                'fname' => 'required|string|max:50',
                'lname' => 'required|string|max:50',
                'mi' => 'nullable|string|max:3',
                'email' => 'required|email|unique:users,email,' . $request->user_id . ',user_id',
                'role_id' => 'required|in:1,2,3',
                'password' => 'nullable|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the user
            $user = User::find($request->user_id);
            
            if (!$user) {
                Log::error('User not found with ID: ' . $request->user_id);
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Log current user data
            Log::info('Current User Data:', [
                'fname' => $user->fname,
                'lname' => $user->lname,
                'email' => $user->email,
                'role_id' => $user->role_id
            ]);

            // Prepare update data
            $updateData = [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mi' => $request->mi ?: null,
                'email' => $request->email,
                'role_id' => $request->role_id
            ];

            // Only update password if provided
            if (!empty($request->password)) {
                $updateData['password'] = Hash::make($request->password);
                Log::info('Password will be updated');
            }

            // Log what we're about to update
            Log::info('Update Data:', $updateData);

            // Perform the update
            $updated = $user->update($updateData);

            Log::info('Update result: ' . ($updated ? 'success' : 'failed'));

            // Reload the user to verify changes
            $user->refresh();
            Log::info('User after update:', [
                'fname' => $user->fname,
                'lname' => $user->lname,
                'email' => $user->email,
                'role_id' => $user->role_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Update Member Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Your other methods remain the same...
    public function getMembers()
    {
        $members = User::with('role')->whereIn('role_id', [1, 2, 3])->get();
        return response()->json(['success' => true, 'members' => $members]);
    }

    public function getRoles()
    {
        $roles = Role::whereIn('role_id', [1, 2, 3])->get();
        return response()->json(['success' => true, 'roles' => $roles]);
    }

    public function deleteMember(Request $request)
    {
        User::where('user_id', $request->user_id)->delete();
        return response()->json(['success' => true, 'message' => 'Member deleted!']);
    }

    public function getMembersCount()
    {
        $count = User::where('role_id', '>=', 1)->count();
        return response()->json(['success' => true, 'count' => $count]);
    }
}