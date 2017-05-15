<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    public function test_unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling();
        $this->post("thread/some-channel/1/reply", [])
            ->assertRedirect('login');
    }

    public function test_a_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post($thread->path() . '/reply', $reply->toArray());
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
