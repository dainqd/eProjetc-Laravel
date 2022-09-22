<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

class TestService extends BaseService
{
    protected $modelClass = Test::class;

    public function listAllByGroup(Group $group): Collection
    {
        return Test::where('group_id', $group->id)->withCount('scores')->get();
    }
}
