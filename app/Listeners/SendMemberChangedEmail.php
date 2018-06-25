<?php

namespace Korona\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Korona\Events\MemberChanged;
use Korona\Mailinglist;
use Mail;

class SendMemberChangedEmail
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
     * @param  MemberChanged  $event
     * @return void
     */
    public function handle(MemberChanged $event)
    {
        $mailinglist = Mailinglist::findOrFail(settings('mail.member_changed_receivers'));

        $receivers = [];
        foreach ($mailinglist->members as $member) {
            if ($member->email != null) {
                $receivers[] = $member->email->email;
            }
        }
        foreach ($mailinglist->people as $person) {
            if ($person->email != null) {
                $receivers[] = $person->email->email;
            }
        }
        $receivers = array_filter($receivers, function ($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        });
        if (empty($receivers)) {
            return;
        }

        Mail::send(['mail.member_changed', 'mail.plain.member_changed'],
            ['member' => $event->model, 'revisions' => $event->revisions],
            function ($m) use ($event, $receivers) {
                foreach ($receivers as $receiver) {
                    $m->to($receiver);
                }
                $m->subject(trans('mail.memberchanged_email_subject',
                    ['member' => $event->model->getShortName()]));
            }
        );
    }
}
