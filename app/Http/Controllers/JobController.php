<?php

namespace App\Http\Controllers;

use App\Jobs\NotificationExtraClassCreated;
use App\Jobs\NotificationExtraClassUpdate;
use App\Jobs\NotificationMark;
use App\Jobs\NotificationMarkUpdate;
use App\Jobs\NotificationResourceCreated;
use App\Jobs\NotificationResourceUpdated;
use App\Models\Group;
use App\Models\Test;
use App\Models\User;

class JobController extends Controller
{
    public function createResource(Group $group){
        $this->dispatch(new NotificationResourceCreated($group));
    }

    public function updateResource(Group $group){
        $this->dispatch(new NotificationResourceUpdated($group));
    }

    public function createExtraClass(Group $group){
        $this->dispatch(new NotificationExtraClassCreated($group));
    }

    public function updateExtraClass(Group $group){
        $this->dispatch(new NotificationExtraClassUpdate($group));
    }

    public function mark(User $user, Test $test, Group $group) {
        $this->dispatch(new NotificationMark($user, $test, $group));
    }

    public function updateMark(User $user, Test $test, Group $group) {
        $this->dispatch(new NotificationMarkUpdate($user, $test, $group));
    }
}
