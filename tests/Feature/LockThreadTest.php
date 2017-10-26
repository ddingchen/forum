<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LockThreadTest extends TestCase
{

    public function test_an_administrator_can_lock_any_thread()
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
