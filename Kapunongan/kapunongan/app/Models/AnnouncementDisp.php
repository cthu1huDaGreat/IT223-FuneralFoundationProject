<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementDisp extends Model
{
    use HasFactory;

    protected $table = 'announcement_disp';

    protected $fillable = ['announcement_id', 'user_id', 'status'];
    
    public $timestamps = false;

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'announcement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}