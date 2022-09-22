<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Teacher || $user->role === UserRole::Student || $user->role === UserRole::Parent;
    }

    public function view(User $user, Group $group): bool
    {
        return
            $user->role === UserRole::Teacher && $user->id === $group->teacher_id || // teacher of that class
            $user->role === UserRole::Student && $user->studyingGroups()->where('group_id', $group->id)->exists() || // student studying that class
            $user->role === UserRole::Parent && $user->children->pluck('user_id')->intersect($group->students->pluck('id'))->count(); // parent of a student studying that class
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::Teacher;
    }

    public function update(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id;
    }

    public function delete(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id && !$group->deleted_at;
    }

    public function restore(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher;
    }

    public function forceDelete(User $user, Group $group): bool
    {
        return false;
    }

    public function remove(User $user, Group $group, User $student): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id && $student->studyingGroups()->where('group_id', $group->id)->exists() && !$group->is_archived;
    }

    public function archive(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id && !$group->is_archived;
    }

    public function unarchive(User $user, Group $group): bool
    {
        return $user->role === UserRole::Teacher && $user->id === $group->teacher_id && $group->is_archived;
    }
}
