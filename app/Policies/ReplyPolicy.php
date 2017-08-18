<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Reply $reply)
    {
        return $user->id == $reply->owner->id;
    }

    public function create(User $user)
    {
        $reply = $user->fresh()->lastReply;
        if (!$reply) {
            return true;
        }
        return !$reply->wasJustPublished();
    }
}
