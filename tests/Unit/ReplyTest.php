<?php

namespace Tests\Unit;

use Tests\TestCase;

class ReplyTest extends TestCase
{
    public function test_a_reply_has_owner()
    {
        $reply = create('App\Reply');
        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
