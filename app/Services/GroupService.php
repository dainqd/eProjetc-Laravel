<?php

namespace App\Services;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupService extends BaseService
{
    protected $modelClass = Group::class;

    public function listOngoing(int $limit): LengthAwarePaginator
    {
        return Group::archived(false)
            ->ofCurrentUser()
            ->paginate($limit);
    }

    public function archived(Group $group): bool
    {
        $group->is_archived = true;
        return $group->save();
    }

    public function listArchived(int $limit): LengthAwarePaginator
    {
        return Group::archived(true)
            ->ofCurrentUser()
            ->paginate($limit);
    }

    public function findByJoinCode(string $joinCode): Group|null
    {
        return Group::where('join_code', $joinCode)->archived(false)->first();
    }

    public function unArchived(Group $group): bool
    {
        $group->is_archived = false;
        return $group->save();
    }

    public function store(mixed $data): Model
    {
        $data['join_code'] = $this->generateUniqueJoinCode();
        return parent::store($data);
    }

    private function generateUniqueJoinCode(): string
    {
        $newCode = Str::random(10);
        if (Group::query()->where(['join_code' => $newCode])->exists()) {
            return $this->generateUniqueJoinCode();
        } else {
            return $newCode;
        }
    }

    public function listOngoingForStudent(int $limit): LengthAwarePaginator
    {
        return Group::archived(false)
            ->ofCurrentStudent()
            ->with('teacher')
            ->paginate($limit);
    }

    public function listArchivedForStudent(int $limit): LengthAwarePaginator
    {
        return Group::archived(true)
            ->ofCurrentStudent()
            ->with('teacher')
            ->paginate($limit);
    }

    public function listOngoingForParent(int $limit): LengthAwarePaginator
    {
        return Group::archived(false)
            ->ofCurrentParent()
            ->with('teacher')
            ->paginate($limit);
    }

    public function listArchivedForParent(int $limit): LengthAwarePaginator
    {
        return Group::archived(true)
            ->ofCurrentParent()
            ->with('teacher')
            ->paginate($limit);
    }

    public function remove(Group $group, User $user): void
    {
        $group->students()->detach($user);
        $group->save();
    }
}
