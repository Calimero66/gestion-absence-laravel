<?php

namespace App\Policies;

use App\Models\Absence;
use App\Models\User;

class AbsencePolicy
{
    /**
     * Determine whether the user can view any absences.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can view a specific absence.
     */
    public function view(User $user, Absence $absence): bool
    {
        return $user->role === 'teacher' && $absence->teacher_id === $user->id;
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
    public function update(User $user, Absence $absence): bool
    {
        return $user->role === 'teacher' && $absence->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete a specific absence.
     */
    public function delete(User $user, Absence $absence): bool
    {
        return $user->role === 'teacher' && $absence->teacher_id === $user->id;
    }
}