<?php

namespace App\Http\Controllers;

use App\Models\FamilyList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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

            $familyMembers = FamilyList::where('user_id', $userId)
                ->orderBy('date_listed', 'desc')
                ->get();

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
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mi' => 'nullable|string|max:3',
            'age' => 'required|integer|min:0|max:120',
            'sex' => 'required|in:Male,Female',
            'bdate' => 'required|date',
            'relation' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20'
        ]);

        try {
            // Get the logged-in user's ID from session
            $userId = Session::get('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            DB::beginTransaction();

            // Convert empty strings to null for nullable fields
            $occupation = $request->occupation === '' ? null : $request->occupation;
            $contact_no = $request->contact_no === '' ? null : $request->contact_no;
            $mi = $request->mi === '' ? null : $request->mi;

            $familyMember = FamilyList::create([
                'user_id' => $userId, // Use session user_id
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mi' => $mi,
                'age' => $request->age,
                'sex' => $request->sex,
                'bdate' => $request->bdate,
                'relation' => $request->relation,
                'occupation' => $occupation,
                'contact_no' => $contact_no,
                'date_listed' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Family member added successfully',
                'familyMember' => $familyMember
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error adding family member: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'family_id' => 'required|exists:family_list,family_id',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mi' => 'nullable|string|max:3',
            'age' => 'required|integer|min:0|max:120',
            'sex' => 'required|in:Male,Female',
            'bdate' => 'required|date',
            'relation' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'contact_no' => 'nullable|string|max:20'
        ]);

        try {
            // Get the logged-in user's ID from session
            $userId = Session::get('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            DB::beginTransaction();

            $familyMember = FamilyList::where('family_id', $request->family_id)
                ->where('user_id', $userId) // Ensure the family member belongs to the logged-in user
                ->firstOrFail();

            // Convert empty strings to null for nullable fields
            $occupation = $request->occupation === '' ? null : $request->occupation;
            $contact_no = $request->contact_no === '' ? null : $request->contact_no;
            $mi = $request->mi === '' ? null : $request->mi;

            $familyMember->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mi' => $mi,
                'age' => $request->age,
                'sex' => $request->sex,
                'bdate' => $request->bdate,
                'relation' => $request->relation,
                'occupation' => $occupation,
                'contact_no' => $contact_no
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Family member updated successfully',
                'familyMember' => $familyMember
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error updating family member: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'family_id' => 'required|exists:family_list,family_id'
        ]);

        try {
            // Get the logged-in user's ID from session
            $userId = Session::get('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            DB::beginTransaction();

            $familyMember = FamilyList::where('family_id', $request->family_id)
                ->where('user_id', $userId) // Ensure the family member belongs to the logged-in user
                ->firstOrFail();

            $familyMember->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Family member deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting family member: ' . $e->getMessage()
            ], 500);
        }
    }
}