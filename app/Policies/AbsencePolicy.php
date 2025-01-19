<?php

namespace App\Policies;

use App\Models\Absence;
use App\Models\User;

class AbsencePolicy
{
    // Determine if the user can view the absence
    public function view(User $user, Absence $absence)
    {
        return $user->id === $absence->user_id || $user->role === 'teacher';
    }

    // Determine if the user can create an absence
    public function create(User $user)
    {
        return $user->role === 'student'; // Only students can create absences
    }

    // Determine if the user can update the absence
    public function update(User $user, Absence $absence)
    {
        return $user->id === $absence->user_id || $user->role === 'teacher';
    }

    // Determine if the user can delete the absence
    public function delete(User $user, Absence $absence)
    {
        return $user->id === $absence->user_id || $user->role === 'teacher';
    }
}