<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Group;
use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Group $group): bool
    {
        return
            $user->role === UserRole::Teacher && $user->id === $group->teacher_id || // teacher of that class
            $user->role === UserRole::Student && $user->studyingGroups()->where('group_id', $group->id)->exists() || // student studying that class
            $user->role === UserRole::Parent && $user->children->pluck('user_id')->intersect($group->students->pluck('id'))->count(); // parent of a student studying that class
    }

    public function view(User $user, Test $test): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $test->group->teacher_id;
    }

    public function create(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id && !$group->is_archived;
    }

    public function update(User $user, Test $test): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $test->group->teacher_id && !$test->group->is_archived;
    }

    public function delete(User $user, Test $test): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $test->group->teacher_id && !$test->group->is_archived;
    }

    public function restore(User $user, Test $test): bool
    {
        return false;
    }

    public function forceDelete(User $user, Test $test): bool
    {
        return false;
    }

    public function mark(User $user, Test $test): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $test->group->teacher_id && !$test->group->is_archived;
    }
}
