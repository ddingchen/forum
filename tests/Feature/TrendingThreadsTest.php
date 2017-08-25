<?php

namespace Tests\Feature;

use App\Trending;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->trending = new Trending();
        $this->trending->del();
    }

    public function test_it_increase_threads_score_each_time_it_is_read()
    {
        $this->assertCount(0, $this->trending->get());

        $thread = create('App\Thread');
        $this->get($thread->path());

        $this->assertCount(1, $this->trending->get());
        $this->assertEquals($thread->title, $this->trending->get()[0]->title);
    }
}
