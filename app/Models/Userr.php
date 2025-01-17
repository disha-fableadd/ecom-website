<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userr extends Model
{
    use HasFactory;

    protected $table = 'user';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'age',
        'gender',
        'mobile',
        'profile_picture',
        'google_id',
    ];

    // If you're using encryption for password field
    protected $hidden = [
        'password',
    ];

    // If you want to cast any attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
