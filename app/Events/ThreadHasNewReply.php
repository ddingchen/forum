<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ThreadHasNewReply
{
    public $thread;

    public $reply;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($thread, $reply)
    {
        //
        $this->thread = $thread;
        $this->reply = $reply;
    }
}
