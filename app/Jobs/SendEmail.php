<?php

namespace Korona\Jobs;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Korona\Generators\Markdown;
use Korona\Jobs\Job;
use Korona\Mailing;
use Korona\User;

class SendEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $receiver;
    protected $mailing;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($receiver, Mailing $mailing)
    {
        $this->receiver = $receiver;
        $this->mailing = $mailing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $environment = [
            'fullname' => $this->receiver->getFullName(),
            'name'     => $this->receiver->getShortName(),
            'salutation_formal' => $this->receiver->getFormalSalutation(),
            'salutation_informal' => $this->receiver->getInformalSalutation()
        ];
        $markdown = new Markdown($environment);
        $body = $markdown->text($this->mailing->text);
        $mailer->send('mail.mailing.' . $this->mailing->layout, ['receiver' => $this->receiver, 'mailing' => $this->mailing, 'body' => $body], function ($m) {
            $m->from($this->mailing->sender->email->email, $this->mailing->sender->getFullName());
            $m->to($this->receiver->email->email, $this->receiver->getFullName());
            $m->subject($this->mailing->subject);
        });
    }
}
