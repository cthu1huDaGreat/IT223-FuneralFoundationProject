<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceMain extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';
    protected $table = 'attendance_main';
    protected $fillable = ['title', 'date', 'tot_present', 'status']; // Add status
    public $timestamps = false;

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'attendance_id');
    }
}