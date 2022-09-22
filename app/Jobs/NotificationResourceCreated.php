<?php

namespace App\Jobs;

use App\MailSupport\SendMailNotificationForResourceCreated;
use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationResourceCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Group $group;
    public function __construct(Group $group)
    {
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
            $users = $this->group->students()->with('student')->get()->filter(function ($data){
                if ($data->student->is_resource_notified){
                    return $data;
                }
            });
            (new SendMailNotificationForResourceCreated())->invoke($users, $this->group);
        }catch (\Exception $e){
            Log::error($e);
        }
    }
}
