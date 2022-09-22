<?php


namespace App\Services;

use App\Models\Group;
use App\Models\User;

class UserService extends BaseService
{
    protected $modelClass = User::class;

    public function hasJoined(Group $group, User $user): bool
    {
        return $group->students()->where('id', $user->id)->exists();
    }

    public function joinClass(Group $group, User $user): void
    {
        $user->studyingGroups()->attach($group);
        $user->save();
    }
}
