<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{

    public function setup()
    {
        parent::setup();

        $this->thread = create('App\Thread');
    }

    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function test_a_thread_can_have_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'new reply',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_notifies_all_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'new reply',
                'user_id' => 1,
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    public function test_a_thread_has_path_with_slug()
    {
        $this->assertEquals("/thread/{$this->thread->channel->slug}/{$this->thread->slug}", $this->thread->path());
    }

    public function test_a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    public function test_a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);
        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    public function test_it_knows_if_it_is_subscribed_to()
    {
        $thread = create('App\Thread');

        $this->signIn();
        $this->assertEquals(false, $thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertEquals(true, $thread->isSubscribedTo);
    }

    public function test_a_thread_can_check_if_a_authenticated_user_has_read_all_replies()
    {
        $thread = create('App\Thread');

        $this->signIn();
        tap(auth()->user(), function ($user) use ($thread) {

            $this->assertTrue($thread->hasUpdatesFor($user));
            $user->read($thread);
            $this->assertFalse($thread->hasUpdatesFor($user));

        });
    }

    public function test_a_thread_records_visits()
    {
        $thread = create('App\Thread');

        $thread->visits()->reset();
        $this->assertEquals(0, $thread->visits()->count());

        $thread->visits()->record();
        $this->assertEquals(1, $thread->visits()->count());

        $thread->visits()->record();
        $this->assertEquals(2, $thread->visits()->count());
    }
}
