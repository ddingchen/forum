<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    public function test_a_guest_may_not_create_new_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('thread', []);
    }

    public function test_an_authenticated_user_can_create_new_thread()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->post('thread', $thread->toArray());
        $this->get("thread/{$thread->id}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
