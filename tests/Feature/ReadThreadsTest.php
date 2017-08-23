<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    public function test_a_user_can_see_threads()
    {
        $thread = create('App\Thread');
        $response = $this->get('thread');
        $response->assertSee($thread->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $thread = create('App\Thread');
        $response = $this->get($thread->path());
        $response->assertSee($thread->body);
    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get("thread/{$channel->slug}")
            ->assertSee($threadInChannel->body)
            ->assertDontSee($threadNotInChannel->body);
    }

    public function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohnDoe = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohnDoe = create('App\Thread');
        $this->get("thread?by=JohnDoe")
            ->assertSee($threadByJohnDoe->body)
            ->assertDontSee($threadNotByJohnDoe->body);
    }

    public function test_a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithoutReplies = create('App\Thread');

        $response = $this->getJson('thread?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    public function test_a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('thread?unanswered=1')->json();

        $this->assertCount(0, $response['data']);

    }

    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        $replies = create('App\Reply', ['thread_id' => $thread->id], 10);

        $json = $this->getJson($thread->path() . '/reply')->json();
        $this->assertCount(10, $json['data']);
    }
}
