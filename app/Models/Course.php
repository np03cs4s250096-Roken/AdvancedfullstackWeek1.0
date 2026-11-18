<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'duration', 'fee', 'difficulty', 'is_active'];

    // Turns the database value 1/0 into true/false in PHP
    protected $casts = ['is_active' => 'boolean'];
}