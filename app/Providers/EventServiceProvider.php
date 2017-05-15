<?php

namespace Korona\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Korona\Events\UserCreated' => [
            'Korona\Listeners\SendNewAccountEmail',
        ],
        'Korona\Events\MemberChanged' => [
            'Korona\Listeners\SendMemberChangedEmail',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        $events->listen('revisionable.*', function($model, $revisions) {
            if ($model instanceof \Korona\Member) {
                event(new \Korona\Events\MemberChanged($model, $revisions));
            }
        });
    }
}
