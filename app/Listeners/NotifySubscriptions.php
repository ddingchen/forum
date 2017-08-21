<?php

namespace App\Listeners;

use App\Events\ThreadReceivesNewReply;

class NotifySubscriptions
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
     * @param  ThreadReceivesNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivesNewReply $event)
    {
        $event->thread->notifySubscribers($event->reply);
    }
}
