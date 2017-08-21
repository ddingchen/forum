<?php

namespace App\Listeners;

use App\Events\ThreadReceivesNewReply;
use App\Notifications\YouAreMentioned;
use App\Reply;
use App\User;

class NotifyMentonedUsers
{
    private $reply;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        //
        $this->reply = $reply;
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivesNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivesNewReply $event)
    {
        $mentionedNames = $event->reply->mentionedUsers();

        collect($mentionedNames)
            ->map(function ($name) {
                return User::whereName($name)->first();
            })
            ->each
            ->notify(new YouAreMentioned($event->reply));
    }
}
