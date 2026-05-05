<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $user = DB::table('users')
            ->where('user_id', $userId)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Validate only non-empty fields for required ones
        $request->validate([
            'lname' => 'sometimes|required|string|max:255',
            'fname' => 'sometimes|required|string|max:255',
            'mi' => 'nullable|string|max:10',
            'age' => 'nullable|integer|min:0',
            'sex' => 'nullable|string|max:10',
            'bdate' => 'nullable|date',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'sometimes|required|email',
            'address' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
        ]);

        try {
            // Build update data array, only including fields that are present in the request
            $updateData = [];
            
            // Only include fields that are actually in the request and not empty (for required fields)
            // For optional fields, include them even if empty to allow clearing
            $fields = [
                'lname', 'fname', 'email', // Required fields - only update if not empty
                'mi', 'age', 'sex', 'bdate', 'contact_no', 'address', 'occupation' // Optional fields
            ];
            
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $value = $request->$field;
                    
                    // For required fields, only update if not empty
                    if (in_array($field, ['lname', 'fname', 'email'])) {
                        if (!empty($value)) {
                            $updateData[$field] = $value;
                        }
                    } else {
                        // For optional fields, update even if empty (to clear the field)
                        $updateData[$field] = $value ?: null;
                    }
                }
            }

            // Check if there are any fields to update
            if (empty($updateData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid data provided to update'
                ]);
            }

            // Update user profile
            $updated = DB::table('users')
                ->where('user_id', $userId)
                ->update($updateData);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No changes made to profile'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }
}