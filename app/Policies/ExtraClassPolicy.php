<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ExtraClass;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExtraClassPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Group $group): bool
    {
        return
            $user->role === UserRole::Teacher && $user->id === $group->teacher_id || // teacher of that class
            $user->role === UserRole::Student && $user->studyingGroups()->where('group_id', $group->id)->exists() || // student studying that class
            $user->role === UserRole::Parent && $user->children->pluck('user_id')->intersect($group->students->pluck('id'))->count(); // parent of a student studying that class
    }

    public function view(User $user, ExtraClass $extraClass): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $extraClass->group->teacher_id;
    }

    public function create(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id && !$group->is_archived;
    }

    public function update(User $user, ExtraClass $extraClass): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $extraClass->group->teacher_id && !$extraClass->group->is_archived;
    }

    public function delete(User $user, ExtraClass $extraClass): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $extraClass->group->teacher_id && !$extraClass->deleted_at && !$extraClass->group->is_archived;
    }

    public function restore(User $user, ExtraClass $extraClass): bool
    {
        return false;
    }

    public function forceDelete(User $user, ExtraClass $extraClass): bool
    {
        return false;
    }
}
