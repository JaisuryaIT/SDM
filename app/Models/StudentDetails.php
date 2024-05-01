<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'roll_no',
        'email',
        'department',
        'gender',
        'year',
        'status',
        'accommodation',
        'community',
        'quota',
        'seat_category',
        'course',
        'religion',
        'residency_status',
        'blood_group',
        'date_of_admission',
    ];
    protected $casts = [
        'date_of_admission' => 'date',
    ];
}
