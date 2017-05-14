<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function test_unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post("thread/1/reply", []);
    }

    public function test_a_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post("thread/{$thread->id}/reply", $reply->toArray());
        $this->get("thread/{$thread->id}")
            ->assertSee($reply->body);
    }
}
