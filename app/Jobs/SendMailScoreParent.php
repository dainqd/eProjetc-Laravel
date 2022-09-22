<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\User;
use App\Services\GroupService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailScoreParent implements ShouldQueue
{
    private $user;
    private $group;
    private $arrayScore;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Group $group, array $arrayScore)
    {
        $this->group = $group;
        $this->user = $user;
        $this->arrayScore = $arrayScore;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $user = User::where('id', $this->user->id)->with('student.parent')->firstOrFail();
            $group = Group::where('id', $this->group->id)->with('teacher')->firstOrFail();
            $teacher = $group->teacher;
            $parent = $user->student->parent;
            Mail::send('mails.parents.send_mail_score', ['student' => $user, 'parent' => $parent, 'datas' => $this->arrayScore, 'group' => $group, 'teacher' => $teacher], function ($msg) use ($parent) {
                $msg->to($parent->email, $parent->full_name)->subject('Score announcement');
                $msg->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            });
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
