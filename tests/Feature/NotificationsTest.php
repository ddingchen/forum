<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    public function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply()
    {

        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here.',
        ]);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply here.',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_a_user_can_fetch_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1, 
            $this->getJson("profile/" . auth()->user() . "/subscription")->json()
        );
    }

    public function test_a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function($user) {

            $this->assertCount(1, $user->unreadNotifications);

            $subscriptionId = $user->unreadNotifications()->first()->id;

            $this->delete("profile/{$user->name}/subscription/{$subscriptionId}");

            $this->assertCount(0, $user->fresh()->unreadNotifications);

        });

    }
}
