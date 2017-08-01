<?php

namespace Tests\Feature;

use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscription');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    public function test_a_user_can_unsubscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->delete($thread->path() . '/subscription');

        $this->assertEquals(0, $thread->subscriptions()->count());
    }
}
