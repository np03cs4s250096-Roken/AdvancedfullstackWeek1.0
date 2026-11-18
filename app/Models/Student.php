<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Only these fields can be saved with Student::create(...)
    protected $fillable = ['name', 'email', 'phone', 'address', 'date_of_birth'];
}
