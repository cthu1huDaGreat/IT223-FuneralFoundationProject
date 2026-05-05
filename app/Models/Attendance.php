<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $fillable = ['attendance_id', 'user_id', 'time', 'status'];
    public $timestamps = false;

    protected $primaryKey = null;
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendanceMain()
    {
        return $this->belongsTo(AttendanceMain::class, 'attendance_id');
    }
}