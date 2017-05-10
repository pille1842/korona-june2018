<?php

namespace Korona\Listeners;

use Korona\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendNewAccountEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        if ($event->notifyByEmail) {
            Mail::send(['mail.new_account', 'mail.plain.new_account'],
                ['user' => $event->user, 'password' => $event->password],
                function ($m) use ($event) {
                    $m->to($event->user->email, $event->user->login);
                    $m->subject(trans('mail.newaccount_email_subject'));
                }
            );
        }
    }
}
