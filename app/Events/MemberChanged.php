<?php

namespace Korona\Events;

use Korona\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MemberChanged extends Event
{
    use SerializesModels;

    public $model;

    public $revisions;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($model, $revisions)
    {
        $this->model = $model;
        $this->revisions = $revisions;
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
