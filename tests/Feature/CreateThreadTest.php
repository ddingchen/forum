<?php

namespace Tests\Feature;

<<<<<<< HEAD
=======
use Illuminate\Foundation\Testing\DatabaseMigrations;
>>>>>>> 30adf86f319db414775bceb3e63e83e5e9ea7849
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
<<<<<<< HEAD
=======
    use DatabaseMigrations;

>>>>>>> 30adf86f319db414775bceb3e63e83e5e9ea7849
    public function test_a_guest_may_not_create_new_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('thread', []);
    }

    public function test_an_authenticated_user_can_create_new_thread()
    {
<<<<<<< HEAD
        $this->signIn();
        $thread = create('App\Thread');
=======
        $this->actingAs(factory('App\User')->create());
        $thread = factory('App\Thread')->create();
>>>>>>> 30adf86f319db414775bceb3e63e83e5e9ea7849
        $this->post('thread', $thread->toArray());
        $this->get("thread/{$thread->id}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
