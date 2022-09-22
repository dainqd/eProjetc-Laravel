<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Group;
use App\Models\Score;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScorePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Group $group): bool
    {
        return
            $user->role === UserRole::Teacher && $user->id === $group->teacher_id || // teacher of that class
            $user->role === UserRole::Student && $user->studyingGroups()->where('group_id', $group->id)->exists() || // student studying that class
            $user->role === UserRole::Parent && $user->children->pluck('user_id')->intersect($group->students->pluck('id'))->count(); // parent of a student studying that class
    }

    public function view(User $user, Group $group, User $student): bool
    {
        return
            $user->role == UserRole::Teacher && $user->id === $group->teacher_id ||
            $user->role == UserRole::Student && $user->id === $student->id ||
            $user->role == UserRole::Parent && $user->children->pluck('user_id')->contains($student->id);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Score $score): bool
    {
        return false;
    }

    public function delete(User $user, Score $score): bool
    {
        return false;
    }

    public function restore(User $user, Score $score): bool
    {
        return false;
    }

    public function forceDelete(User $user, Score $score): bool
    {
        return false;
    }
}
