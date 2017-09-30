<?php

namespace Tests\Feature;

use App\Activity;
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

    public function test_an_authenticated_user_cannot_publish_threads_before_they_confirm_the_email()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $thread = make('App\Thread');
        return $this->signIn($user)
            ->withExceptionHandling()
            ->post('thread', $thread->toArray())
            ->assertRedirect('thread')
            ->assertSessionHas('flash.message', 'Email must be confirmed first!.');
    }

    public function test_an_authenticated_user_can_create_new_thread()
    {
        $thread = make('App\Thread');
        $response = $this->publishThread($thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_thread_requires_unique_slugs()
    {
        create('App\Thread', [], 2);
        $thread = create('App\Thread', ['title' => 'Help me 23']);
        $thread = create('App\Thread', ['title' => 'Help me 23']);

        $json = $this->signIn()
            ->postJson('thread', $thread->toArray())->json();

        $this->assertEquals('help-me-23-' . $json['id'], $json['slug']);
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

    public function test_unauthorized_users_cannot_delete_threads()
    {
        $thread = create('App\Thread');

        $this->withExceptionHandling()
            ->delete($thread->path())
            ->assertRedirect('login');

        $this->signIn()
            ->delete($thread->path())
            ->assertStatus(403);
        $this->assertDatabaseHas('threads', ['id' => $thread->id]);
    }

    public function test_authorized_user_can_delete_threads()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('delete', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    private function publishThread($attributes = [])
    {
        $thread = make('App\Thread', $attributes);
        return $this->signIn()
            ->withExceptionHandling()
            ->post('thread', $thread->toArray());
    }
}
