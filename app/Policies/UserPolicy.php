<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function view(User $user, User $model): bool
    {
        return $user->role === UserRole::Admin || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === UserRole::Admin || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === UserRole::Admin && $user->id !== $model->id && !$model->deleted_at;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function joinClass(User $user): bool
    {
        return $user->role === UserRole::Student;
    }

    public function settings(User $user): bool
    {
        return $user->role === UserRole::Student;
    }
}
