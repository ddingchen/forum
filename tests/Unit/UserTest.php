<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function test_a_user_can_determine_their_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals('/img/generic-avatar.png', $user->avatar_path);

        $user->avatar_path = 'avatars/my.jpg';

        $this->assertEquals('/storage/avatars/my.jpg', $user->avatar_path);
    }
}
