<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationRemoveParent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $student;
    private $parent;
    public function __construct(User $user, int $parent_id)
    {
        $this->student = $user;
        $this->parent = (new User())->find($parent_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::send('mails.parents.notification_remove_parent', ['student' => $this->student, 'parent' => $this->parent], function ($msg) {
                $msg->to($this->parent->email, $this->parent->full_name)->subject('Notice to remove student\'s parent role');
                $msg->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            });
        }catch (\Exception $e){
            Log::error($e);
        }
    }
}
