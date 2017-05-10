<?php

namespace Korona\Events;

use Korona\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Korona\User;

class UserCreated extends Event
{
    use SerializesModels;

    public $user;
    public $password;
    public $notifyByEmail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $password, $notifyByEmail = false)
    {
        $this->user = $user;
        $this->password = $password;
        $this->notifyByEmail = $notifyByEmail;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
