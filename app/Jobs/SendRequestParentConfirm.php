<?php

namespace App\Jobs;

use App\Mail\RequestParentConfirmMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRequestParentConfirm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $parent;
    private $confirmCode;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->parent = (new User())->find($user->student->parent_id);
        $this->confirmCode = $user->student->parent_confirmation_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::send('mails.parents.request_parent_confirm', ['student' => $this->user, 'parent' => $this->parent, 'code' => $this->confirmCode], function ($msg) {
                $msg->to($this->parent->email, $this->parent->full_name)->subject('Confirm you are the student\'s parent');
                $msg->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            });
        }catch (\Exception $e){
            Log::error($e);
        }
    }
}
