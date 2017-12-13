<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;

class UpdateThreadTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    public function test_a_thread_can_be_updated_by_its_creator()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'new title',
            'body' => 'new body',
        ])->assertStatus(200);

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('new title', $thread->title);
            $this->assertEquals('new body', $thread->body);
        });
    }

    public function test_a_thread_requires_title_and_body_to_be_update()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->withExceptionHandling()
            ->patch($thread->path(), [])
            ->assertSessionHasErrors('title')
            ->assertSessionHasErrors('body');
    }

    public function test_unauthorized_user_may_not_update_threads()
    {
        $thread = create(Thread::class, ['user_id' => create(User::class)->id]);

        $this->withExceptionHandling()
            ->patch($thread->path())
            ->assertStatus(403);
    }

}
