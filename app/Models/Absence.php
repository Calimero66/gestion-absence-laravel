<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    protected $fillable = [
        'date',
        'session',
        'justification',
        'penalty',
        'status',
        'user_id',
        'teacher_id',
    ];

    // Define relationship with User (student)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Student
    }

    // Define relationship with Teacher (user who created the absence)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id'); // Teacher who created the absence
    }

}
