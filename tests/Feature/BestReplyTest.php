<?php

namespace Tests\Feature;

use Tests\TestCase;

class BestReplyTest extends TestCase
{
    public function test_a_reply_could_be_mark_best()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $replies = create('App\Reply', ['thread_id' => $thread->id], 3);

        $this->postJson(route('best-reply.store', $replies->last()->id));

        $this->assertTrue($replies->last()->fresh()->isBest());
    }

    public function test_only_thread_owner_can_mark_best()
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->signIn(create('App\User'));

        $this->postJson(route('best-reply.store', $reply->id))->assertStatus(403);
        $this->assertFalse($reply->fresh()->isBest());

    }
}
