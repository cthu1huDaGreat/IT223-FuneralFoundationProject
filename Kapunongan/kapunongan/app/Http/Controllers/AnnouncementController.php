<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementDisp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AnnouncementController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $formattedDate = now()->format('m/d/Y g:iA');

            DB::statement('CALL add_announcement(?, ?, ?)', [
                $request->title,
                $request->message,
                $formattedDate
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Announcement posted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function dismiss(Request $request)
        {
            $request->validate([
                'announcement_id' => 'required'
            ]);

            $userId = Session::get('user_id');

            DB::statement('CALL dismiss_announcement(?, ?)', [
                $request->announcement_id,
                $userId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dismissed successfully'
            ]);
        }

    public function getAnnouncements()
        {
            $userId = Session::get('user_id');

            if (!$userId) {
                return collect();
            }

            return DB::select('CALL get_user_announcements(?)', [$userId]);
        }
        
    public function delete(Request $request)
    {
        // Validate the request
        $request->validate([
            'announcement_id' => 'required|exists:announcements,announcement_id'
        ]);

        try {
            DB::beginTransaction();

            $announcementId = $request->announcement_id;

            // Delete from announcement_disp table first (child records)
            AnnouncementDisp::where('announcement_id', $announcementId)->delete();

            // Delete from announcements table
            $deleted = Announcement::where('announcement_id', $announcementId)->delete();

            if ($deleted) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Announcement deleted successfully!'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Announcement not found or already deleted.'
                ], 404);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting announcement: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting announcement: ' . $e->getMessage()
            ], 500);
        }
    }

}