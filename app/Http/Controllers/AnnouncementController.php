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
    // Validate the request
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    try {
        DB::beginTransaction();
        $formattedDate = now()->format('m/d/Y g:iA');
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->message,
            'date' => $formattedDate,
        ]);

        $users = User::all();

        if ($users->isEmpty()) {
            throw new \Exception('No users found in the database.');
        }

        foreach ($users as $user) {
            AnnouncementDisp::create([
                'announcement_id' => $announcement->announcement_id,
                'user_id' => $user->user_id,
                'status' => 1,
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Announcement posted successfully to ' . $users->count() . ' users!'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => 'Error posting announcement: ' . $e->getMessage()
        ], 500);
    }
}
    public function dismiss(Request $request)
    {
        $request->validate([
            'announcement_id' => 'required|exists:announcements,announcement_id'
        ]);

        try {

            $userId = Session::get('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated. Please login again.'
                ], 401);
            }

            $updated = AnnouncementDisp::where('announcement_id', $request->announcement_id)
                ->where('user_id', $userId)
                ->update(['status' => 0]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Announcement dismissed successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Announcement not found or already dismissed.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error dismissing announcement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAnnouncements()
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return collect(); 
        }

        $announcements = AnnouncementDisp::with('announcement')
            ->where('user_id', $userId)
            ->where('status', 1) 
            ->join('announcements', 'announcement_disp.announcement_id', '=', 'announcements.announcement_id')
            ->select('announcements.*', 'announcement_disp.announcement_id')
            ->orderBy('announcements.date', 'desc')
            ->get();

        return $announcements;
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