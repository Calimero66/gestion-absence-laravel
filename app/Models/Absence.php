<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    protected $fillable = [
        'date',
        'reason',
        'type',
        'user_id',  // The student's ID
        'teacher_id', // The teacher's ID
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
