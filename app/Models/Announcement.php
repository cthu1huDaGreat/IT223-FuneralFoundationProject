<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $primaryKey = 'announcement_id'; // Make sure this matches your announcements table primary key

    protected $fillable = ['title', 'content', 'date'];
    
    public $timestamps = false;

    public function displays()
    {
        return $this->hasMany(AnnouncementDisp::class, 'announcement_id');
    }
}