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

    public function test_a_reply_requires_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        $this->post($thread->path() . '/reply', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    public function test_unauthorized_user_may_not_delete_reply()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->signIn()
            ->delete("reply/{$reply->id}")
            ->assertStatus(403);
    }

    public function test_an_authorized_user_can_delete_reply()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("reply/{$reply->id}");
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
