<?php

namespace App\Services;

use App\Models\ExtraClass;
use App\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;

class ExtraClassService extends BaseService
{
    protected $modelClass = ExtraClass::class;

}
