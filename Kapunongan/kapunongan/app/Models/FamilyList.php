<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyList extends Model
{
    use HasFactory;

    protected $primaryKey = 'family_id';
    protected $table = 'family_list';
    
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'mi',          // nullable
        'age',
        'sex',
        'bdate',
        'relation',
        'occupation',  // nullable
        'contact_no',  // nullable
        'date_listed'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}