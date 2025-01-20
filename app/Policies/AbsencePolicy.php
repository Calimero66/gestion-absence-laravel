<?php

namespace App\Policies;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsencePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any absences.
     */
    public function viewAny(User $user): bool
    {
        // Only teachers and students can view absences
        return in_array($user->role, ['teacher', 'student']);
    }

    /**
     * Determine whether the user can view a specific absence.
     */
    public function view(User $user, Absence $absence)
    {
        // If user is a teacher, they can view absences they created
        if ($user->role === 'teacher') {
            return $user->id === $absence->teacher_id;
        }

        // If user is a student, they can only view their own absences
        if ($user->role === 'student') {
            return $user->id === $absence->user_id;
        }

        return false;
    }
    /**
     * Determine whether the user can create an absence.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can update a specific absence.
     */
    public function update(User $user, Absence $absence)
    {
        // Teachers can update any field of absences they created
        if ($user->role === 'teacher') {
            return $user->id === $absence->teacher_id;
        }

        // Students can only upload justification for their own absences
        if ($user->role === 'student') {
            return $user->id === $absence->user_id;
        }

        return false;
        
    }

    /**
     * Determine whether the user can delete a specific absence.
     */
    public function delete(User $user, Absence $absence): bool
    {
        return $user->role === 'teacher' && $absence->teacher_id === $user->id;
    }

}