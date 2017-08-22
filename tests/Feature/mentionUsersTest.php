<?php

namespace Tests\Feature;

use Tests\TestCase;

class mentionUsersTest extends TestCase
{
    public function test_mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);

        $jane = create('App\User', ['name' => 'janeDoe']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => '@janeDoe look at this.',
        ]);

        $this->post($thread->path() . '/reply', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    public function test_it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'JohnDoe']);
        create('App\User', ['name' => 'JohnDoe2']);
        create('App\User', ['name' => 'JaneDoe']);

        $result = $this->json('get', 'api/users', ['name' => 'John'])->json();

        $this->assertCount(2, $result);
    }
}
