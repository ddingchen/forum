<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    public function test_a_reply_has_owner()
    {
        $reply = create('App\Reply');
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    public function test_a_reply_has_many_favorites()
    {
        $reply = create('App\Reply');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $reply->favorites);
    }

    public function test_it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subHour();

        $this->assertFalse($reply->wasJustPublished());
    }
}
