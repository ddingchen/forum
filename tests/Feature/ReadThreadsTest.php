<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function test_a_user_can_see_threads()
    {
        $threads = factory('App\Thread', 10)->create();
        $response = $this->get('thread');
        $response->assertSee($threads->first()->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get("thread/{$thread->id}");
        $response->assertSee($thread->body);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        $response = $this->get("thread/{$thread->id}");
        $response->assertSee($reply->body);
    }
}
