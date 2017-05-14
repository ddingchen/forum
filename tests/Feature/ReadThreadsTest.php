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
        $response = $this->get("thread/{$thread->id}");
        $response->assertSee($thread->body);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);
        $response = $this->get("thread/{$thread->id}");
        $response->assertSee($reply->body);
    }
}
