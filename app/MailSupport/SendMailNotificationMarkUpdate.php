<?php

namespace App\MailSupport;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailNotificationMarkUpdate
{
    public function invoke($user, $test, $group)
    {
        try {
            Mail::send('mails.users.notification_mark_update', ['user' => $user, 'test' => $test, 'group' => $group], function ($msg) use ($user, $test) {
                $msg->to($user->email, $user->full_name)->subject('Test update scores of ' . $test->name . ' exam');
                $msg->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            });

        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
