<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Resource;

class ResourceService extends BaseService
{
    protected $modelClass = Resource::class;
    public function getByGroup(Group $group,int $limit){
        return Resource::where('group_id',$group->id)->paginate($limit);
    }
}
