<?php

namespace App\Http\Controllers;

use App\Models\AttendanceMain;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'required|date'
    ]);

    try {
        DB::beginTransaction();

        // Get only users with role_id >= 1
        $members = User::where('role_id', '>=', 1)->get();
        $totalMembers = $members->count();

        // Create attendance_main record
        $attendance = AttendanceMain::create([
            'title' => $request->title,
            'date' => $request->date,
            'tot_present' => 0
        ]);

        // Create attendance records only for members with role_id >= 1
        foreach ($members as $member) {
            Attendance::create([
                'attendance_id' => $attendance->attendance_id,
                'user_id' => $member->user_id,
                'status' => 1, // Pending
                'time' => null
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Attendance created successfully',
            'total_members' => $totalMembers
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error creating attendance: ' . $e->getMessage()
        ], 500);
    }
}

public function index()
{
    try {
        // Check if status column exists in the table
        $connection = DB::connection();
        $schema = $connection->getSchemaBuilder();
        $hasStatus = $schema->hasColumn('attendance_main', 'status');
        
        $query = AttendanceMain::select('attendance_id', 'title', 'date', 'tot_present');
        
        if ($hasStatus) {
            $query->addSelect('status');
        }
        
        $attendanceRecords = $query->orderBy('date', 'desc')->get();

        // Add status if column doesn't exist
        if (!$hasStatus) {
            $attendanceRecords->each(function ($record) {
                $record->status = 1; // Default to active
            });
        }

        // Manually count total members for each attendance record
        $attendanceRecords->each(function ($record) {
            $record->total_members = Attendance::where('attendance_id', $record->attendance_id)->count();
        });

        return response()->json([
            'success' => true,
            'attendanceRecords' => $attendanceRecords,
            'has_status_column' => $hasStatus // For debugging
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in attendance index: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error fetching attendance records: ' . $e->getMessage()
        ], 500);
    }
}
    public function getAttendanceData($id)
{
    try {
        \Log::info('Fetching attendance data for ID: ' . $id);
        
        $attendanceMain = AttendanceMain::find($id);
        if (!$attendanceMain) {
            \Log::error('Attendance main record not found for ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'Attendance record not found'
            ], 404);
        }

        // Use raw join to ensure we get only users with role_id >= 1
        $attendanceData = DB::table('attendance')
            ->join('users', 'attendance.user_id', '=', 'users.user_id')
            ->where('attendance.attendance_id', $id)
            ->where('users.role_id', '>=', 1) // Only users with role_id >= 1
            ->select(
                'attendance.attendance_id',
                'attendance.user_id',
                'attendance.time',
                'attendance.status',
                'users.fname as first_name',
                'users.lname as last_name',
                'users.email',
                'users.role_id' // Include role_id for debugging
            )
            ->get();

        \Log::info('Found ' . $attendanceData->count() . ' attendance records for role_id >= 1');
        
        if ($attendanceData->count() > 0) {
            \Log::info('Sample data:', (array)$attendanceData->first());
        }

        return response()->json([
            'success' => true,
            'attendanceData' => $attendanceData
        ]);

    } catch (\Exception $e) {
        \Log::error('Error fetching attendance data for ID ' . $id . ': ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error fetching attendance data: ' . $e->getMessage()
        ], 500);
    }
}

    public function updateStatus(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:attendance_main,attendance_id',
        'user_id' => 'required|exists:users,user_id',
        'status' => 'required|in:1,2,3'
    ]);

    try {
        DB::beginTransaction();

        $time = $request->status == 2 ? now()->setTimezone('Asia/Manila') : null;

        $updated = Attendance::where('attendance_id', $request->attendance_id)
            ->where('user_id', $request->user_id)
            ->update([
                'status' => $request->status,
                'time' => $time
            ]);

        if ($updated === 0) {
            throw new \Exception('No record found to update');
        }

        // Update tot_present in attendance_main
        $presentCount = Attendance::where('attendance_id', $request->attendance_id)
            ->where('status', 2)
            ->count();

        AttendanceMain::where('attendance_id', $request->attendance_id)
            ->update(['tot_present' => $presentCount]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Attendance status updated successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error updating attendance status: ' . $e->getMessage()
        ], 500);
    }
}

    public function close(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:attendance_main,attendance_id'
    ]);

    try {
        DB::beginTransaction();

        // Update all pending records to absent (only for users with role_id >= 1)
        $updated = Attendance::join('users', 'attendance.user_id', '=', 'users.user_id')
            ->where('attendance.attendance_id', $request->attendance_id)
            ->where('attendance.status', 1) // Pending
            ->where('users.role_id', '>=', 1) // Only users with role_id >= 1
            ->update(['attendance.status' => 3]); // Absent

        // Update tot_present in attendance_main (only counting users with role_id >= 1)
        $presentCount = Attendance::join('users', 'attendance.user_id', '=', 'users.user_id')
            ->where('attendance.attendance_id', $request->attendance_id)
            ->where('attendance.status', 2) // Present
            ->where('users.role_id', '>=', 1) // Only users with role_id >= 1
            ->count();

        AttendanceMain::where('attendance_id', $request->attendance_id)
            ->update(['tot_present' => $presentCount]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Attendance closed successfully',
            'updated_count' => $updated,
            'present_count' => $presentCount
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error closing attendance: ' . $e->getMessage()
        ], 500);
    }
}
public function archive(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:attendance_main,attendance_id'
    ]);

    try {
        // Check if status column exists
        $schema = DB::getSchemaBuilder();
        $hasStatus = $schema->hasColumn('attendance_main', 'status');
        
        if ($hasStatus) {
            AttendanceMain::where('attendance_id', $request->attendance_id)
                ->update(['status' => 2]); // 2 = archived

            return response()->json([
                'success' => true,
                'message' => 'Attendance archived successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Archive feature not available. Status column is missing from the database.'
            ], 400);
        }

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error archiving attendance: ' . $e->getMessage()
        ], 500);
    }
}

public function delete(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:attendance_main,attendance_id'
    ]);

    try {
        DB::beginTransaction();

        // Delete attendance records first
        Attendance::where('attendance_id', $request->attendance_id)->delete();
        
        // Then delete the main record
        AttendanceMain::where('attendance_id', $request->attendance_id)->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error deleting attendance: ' . $e->getMessage()
        ], 500);
    }
}
}