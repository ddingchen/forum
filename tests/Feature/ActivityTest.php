<?php

namespace Tests\Feature;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    public function test_it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_type' => 'App\Thread',
            'subject_id' => $thread->id,
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(Activity::count(), 2);
    }

    public function test_it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()], 2);
        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $activities = Activity::feed(auth()->user());

        $this->assertTrue($activities->keys()->contains(Carbon::now()->subWeek()->format('Y-m-d')));
    }
}
