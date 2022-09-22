<?php

namespace App\Jobs;

use App\MailSupport\SendMailNotificationMarkUpdate;
use App\Models\Group;
use App\Models\Test;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationMarkUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;
    private Test $test;
    private Group $group;
    public function __construct(User $user, Test $test, Group $group)
    {
        $this->user = $user;
        $this->test = $test;
        $this->group = $group;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            (new SendMailNotificationMarkUpdate())->invoke($this->user, $this->test, $this->group);
        }catch (\Exception $e){
            Log::error($e);
        }
    }
}
