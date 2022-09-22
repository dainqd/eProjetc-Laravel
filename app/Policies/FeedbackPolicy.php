<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function view(User $user, Feedback $feedback): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function create(User $user): bool
    {
        return $user->role !== UserRole::Admin;
    }

    public function update(User $user): bool
    {
        return false;
    }

    public function delete(User $user, Feedback $feedback): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function restore(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function forceDelete(User $user): bool
    {
        return false;
    }
}
