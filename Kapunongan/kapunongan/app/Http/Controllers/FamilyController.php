<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FamilyController extends Controller
{
public function index()
    {
        try {
            // Get the logged-in user's ID from session
            $userId = Session::get('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Execute the Stored Procedure instead of using a Model
            $familyMembers = DB::select('CALL GetFamilyMembersByUserId(?)', [$userId]);

            return response()->json([
                'success' => true,
                'familyMembers' => $familyMembers
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading family members: ' . $e->getMessage()
            ], 500);
        }
    }

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fname'      => 'required|string|max:255',
        'lname'      => 'required|string|max:255',
        'mi'         => 'nullable|string|max:3',
        'age'        => 'required|integer|min:0',
        'sex'        => 'required|in:Male,Female',
        'bdate'      => 'required|date',
        'relation'   => 'required|string|max:255',
        'occupation' => 'nullable|string|max:255',
        'contact_no' => 'nullable|string|max:20'
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
    }

    try {
        $userId = Session::get('user_id');
        
        // We pass the values directly. If they are empty strings, 
        // the SQL NULLIF() will handle the rest.
        DB::statement('CALL AddFamilyMember(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $userId,
            $request->fname,
            $request->lname,
            $request->mi,
            $request->age,
            $request->sex,
            $request->bdate,
            $request->relation,
            $request->occupation,
            $request->contact_no
        ]);

        return response()->json(['success' => true, 'message' => 'Added successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'family_id'  => 'required|integer',
            'fname'      => 'required|string|max:255',
            'lname'      => 'required|string|max:255',
            'mi'         => 'nullable|string|max:3',
            'age'        => 'required|integer|min:0|max:120',
            'sex'        => 'required|in:Male,Female',
            'bdate'      => 'required|date',
            'relation'   => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $userId = Session::get('user_id');
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            DB::statement('CALL UpdateFamilyMember(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->family_id,
                $userId,
                $request->fname,
                $request->lname,
                $request->mi,
                $request->age,
                $request->sex,
                $request->bdate,
                $request->relation,
                $request->occupation,
                $request->contact_no
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Family member updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating family member: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'family_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid ID'], 422);
        }

        try {
            // 2. Get the logged-in user's ID from session
            $userId = Session::get('user_id');
            
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            // 3. Execute the Stored Procedure
            // This ensures only the owner can delete the record
            DB::statement('CALL DeleteFamilyMember(?, ?)', [
                $request->family_id,
                $userId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Family member deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting family member: ' . $e->getMessage()
            ], 500);
        }
    }
}