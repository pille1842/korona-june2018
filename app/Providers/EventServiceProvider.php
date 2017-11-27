<?php

namespace Korona\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Korona\Address;
use Korona\Email;
use Korona\Member;
use Korona\Person;
use Korona\Phonenumber;
use Korona\Mailinglist;
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

        Email::creating(function ($email) {
            $emailable = $email->emailable;
            $revision = new \Venturecraft\Revisionable\Revision;
            $revision->user_id = Auth::user() ? Auth::user()->id : null;
            $revision->key = 'email';
            $revision->old_value = null;
            $revision->new_value = $email->identifiableName();
            $emailable->revisionHistory()->save($revision);
            \Event::fire('revisionable.saved', array('model' => $emailable, 'revisions' => [$revision]));
        });

        Email::deleting(function ($email) {
            $emailable = $email->emailable;
            $revision = new \Venturecraft\Revisionable\Revision;
            $revision->user_id = Auth::user() ? Auth::user()->id : null;
            $revision->key = 'email';
            $revision->new_value = null;
            $revision->old_value = $email->identifiableName();
            $emailable->revisionHistory()->save($revision);
            \Event::fire('revisionable.saved', array('model' => $emailable, 'revisions' => [$revision]));
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

        Member::deleting(function ($member) {
            if ($member->deleted_at) {
                $member->addresses()->delete();
                $member->phonenumbers()->delete();
                $member->offices()->delete();
                $member->subscriptions()->detach();
                $member->revisionHistory()->delete();
            }
        });

        Person::deleting(function ($person) {
            if ($person->deleted_at) {
                $person->addresses()->delete();
                $person->phonenumbers()->delete();
                $person->subscriptions()->detach();
                $person->revisionHistory()->delete();
            }
        });

        Mailinglist::deleting(function ($mailinglist) {
            $mailinglist->members()->detach();
            $mailinglist->people()->detach();
        });
    }
}
