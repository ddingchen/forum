<?php

namespace Tests\Feature;

use App\Activity;
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
}
