<?php

namespace App\MailSupport;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailNotificationForResourceUpdated
{
    public function invoke($users, $group)
    {
        try {
            foreach ($users as $user) {
                Mail::send('mails.users.notification_resource', ['user' => $user, 'group' => $group, 'type' => 'update'], function ($msg) use ($user, $group) {
                    $msg->to($user->email, $user->full_name)->subject('Update resource for '.$group->name);
                    $msg->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
                });
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
