<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_guest_may_not_create_new_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('thread', []);
    }

    public function test_an_authenticated_user_can_create_new_thread()
    {
        $this->actingAs(factory('App\User')->create());
        $thread = factory('App\Thread')->create();
        $this->post('thread', $thread->toArray());
        $this->get("thread/{$thread->id}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
