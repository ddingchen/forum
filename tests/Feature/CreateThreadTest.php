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

    public function test_guest_cannot_delete_threads()
    {
        $thread = create('App\Thread');

        $this->withExceptionHandling()
            ->delete($thread->path())
            ->assertRedirect('login');
    }

    public function test_a_thread_can_be_deleted()
    {
        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->signIn()
            ->json('delete', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    private function publishThread($attributes = [])
    {
        $thread = make('App\Thread', $attributes);
        return $this->withExceptionHandling()
            ->signIn()
            ->post('thread', $thread->toArray());
    }
}
