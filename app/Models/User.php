<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'lname', 'fname', 'mi', 'email', 'password', 'role_id',
        'age', 'sex', 'bdate', 'contact_no', 'address', 'occupation'
    ];

    // Fix the relationship
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}