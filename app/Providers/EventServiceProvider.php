<?php

namespace Korona\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Korona\Address;
use Korona\Phonenumber;
use Auth;

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

        Address::creating(function ($address) {
            $addressable = $address->addressable;
            $revision = new \Venturecraft\Revisionable\Revision;
            $revision->user_id = Auth::user() ? Auth::user()->id : null;
            $revision->key = 'address';
            $revision->old_value = null;
            $revision->new_value = $address->identifiableName();
            $addressable->revisionHistory()->save($revision);
            \Event::fire('revisionable.saved', array('model' => $addressable, 'revisions' => [$revision]));
        });

        Address::deleting(function ($address) {
            $addressable = $address->addressable;
            $revision = new \Venturecraft\Revisionable\Revision;
            $revision->user_id = Auth::user() ? Auth::user()->id : null;
            $revision->key = 'address';
            $revision->new_value = null;
            $revision->old_value = $address->identifiableName();
            $addressable->revisionHistory()->save($revision);
            \Event::fire('revisionable.saved', array('model' => $addressable, 'revisions' => [$revision]));
        });

        Phonenumber::creating(function ($phonenumber) {
            $phoneable = $phonenumber->phoneable;
            $revision = new \Venturecraft\Revisionable\Revision;
            $revision->user_id = Auth::user() ? Auth::user()->id : null;
            $revision->key = 'phonenumber';
            $revision->old_value = null;
            $revision->new_value = $phonenumber->identifiableName();
            $phoneable->revisionHistory()->save($revision);
            \Event::fire('revisionable.saved', array('model' => $phoneable, 'revisions' => [$revision]));
        });

        Phonenumber::deleting(function ($phonenumber) {
            $phoneable = $phonenumber->phoneable;
            $revision = new \Venturecraft\Revisionable\Revision;
            $revision->user_id = Auth::user() ? Auth::user()->id : null;
            $revision->key = 'phonenumber';
            $revision->new_value = null;
            $revision->old_value = $phonenumber->identifiableName();
            $phoneable->revisionHistory()->save($revision);
            \Event::fire('revisionable.saved', array('model' => $phoneable, 'revisions' => [$revision]));
        });
    }
}
