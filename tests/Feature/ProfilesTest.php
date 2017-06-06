<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProfilesTest extends TestCase
{
    public function test_a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get("profile/{$user->name}")
            ->assertSee($user->name);
    }

    public function test_profile_display_all_threads_created_by_associated_user()
    {
        $user = create('App\User');
        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get("profile/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
