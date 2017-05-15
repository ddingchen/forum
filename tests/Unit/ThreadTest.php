<?php

namespace Tests\Unit;

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

    public function test_a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    public function test_a_thread_can_make_string_path()
    {
        $this->assertEquals("/thread/{$this->thread->channel->slog}/{$this->thread->id}", $this->thread->path());
    }
}
