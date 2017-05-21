<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    public function test_a_user_can_see_threads()
    {
        $thread = create('App\Thread');
        $response = $this->get('thread');
        $response->assertSee($thread->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $thread = create('App\Thread');
        $response = $this->get($thread->path());
        $response->assertSee($thread->body);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $response = $this->get($thread->path());
        $response->assertSee($reply->body);
    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get("thread/{$channel->slug}")
            ->assertSee($threadInChannel->body)
            ->assertDontSee($threadNotInChannel->body);
    }

    public function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohnDoe = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohnDoe = create('App\Thread');
        $this->get("thread?by=JohnDoe")
            ->assertSee($threadByJohnDoe->body)
            ->assertDontSee($threadNotByJohnDoe->body);
    }
}
