<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class LockThreadTest extends TestCase
{

    public function test_non_administrator_may_not_lock_thread()
    {
        $this->signIn()
            ->withExceptionHandling();

        $thread = create(Thread::class);

        $this->post(route('locked-thread.store', $thread))
            ->assertStatus(403);
    }

    public function test_an_administrator_may_lock_thread()
    {
        $this->signIn(factory(User::class)->states('admin')->create());

        $thread = create(Thread::class);

        $this->post(route('locked-thread.store', $thread))
            ->assertStatus(200);

        $this->assertTrue($thread->fresh()->locked);
    }

    public function test_once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create(Thread::class);
        $thread->lock();

        $this->post($thread->path() . '/reply', [
            'body' => 'something',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }

}
