<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    public function test_a_guest_may_not_create_new_thread()
    {
        $this->withExceptionHandling();

        $this->get('thread/create')
            ->assertRedirect('login');

        $this->post('thread')
            ->assertRedirect('login');
    }

    public function test_an_authenticated_user_can_create_new_thread()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('thread', $thread->toArray());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 5])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread($attributes = [])
    {
        $thread = make('App\Thread', $attributes);
        return $this->withExceptionHandling()
            ->signIn()
            ->post('thread', $thread->toArray());
    }
}
