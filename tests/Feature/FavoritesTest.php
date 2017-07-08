<?php

namespace Tests\Feature;

use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function test_guest_cannot_favorite_replies()
    {
        $this->withExceptionHandling()
            ->post("reply/1/favorites")
            ->assertRedirect('login');
    }

    public function test_an_authenticated_user_can_favorite_replies()
    {
        $reply = create('App\Reply');
        $this->signIn()->post("reply/{$reply->id}/favorites");
        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $reply = create('App\Reply');
        $this->signIn();
        $this->post("reply/{$reply->id}/favorites");
        $this->post("reply/{$reply->id}/favorites");
        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_may_unfavorite_a_reply()
    {
        $reply = create('App\Reply');
        $this->signIn();

        $reply->favorite();
        $this->delete("reply/{$reply->id}/favorites");

        $this->assertCount(0, $reply->favorites);
    }
}
