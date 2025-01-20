<?php

namespace App\Policies;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbsencePolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['student', 'teacher']);
    }

    public function view(User $user, Absence $absence)
    {
        return $user->id === $absence->user_id || $user->id === $absence->teacher_id;
    }

    public function create(User $user)
    {
        return $user->role === 'teacher';
    }

    public function update(User $user, Absence $absence)
    {
        return $user->id === $absence->teacher_id;
    }

    public function delete(User $user, Absence $absence)
    {
        return $user->id === $absence->teacher_id;
    }

    public function uploadJustification(User $user, Absence $absence)
    {
        // Students can only upload justification for their own absences
        return $user->role === 'student' && $user->id === $absence->user_id;
    }
}
