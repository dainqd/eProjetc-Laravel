<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationCreateAccountSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::send('mails.parents.notification_remove_parent', ['user' => $this->user], function ($msg) {
                $msg->to($this->user->email, $this->user->full_name)->subject('Create account success!');
                $msg->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            });
        }catch (\Exception $e){
            Log::error($e);
        }
    }
}
