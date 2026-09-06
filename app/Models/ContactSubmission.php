<?php

namespace App\Models;

use App\Enums\StudentLevel;
use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'parent_name',
        'student_age',
        'phone',
        'email',
        'level',
        'schedule',
        'message',
        'status',
        'notes',
    ];

    protected $casts = [
        'level' => StudentLevel::class,
        'status' => SubmissionStatus::class,
        'schedule' => 'array',
        'student_age' => 'integer',
    ];
}
