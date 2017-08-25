<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Redis::del('trending.threads');
    }

    public function test_it_increase_threads_score_each_time_it_is_read()
    {
        $this->assertCount(0, Redis::zrevrange('trending.threads', 0, 0));

        $thread = create('App\Thread');

        $this->get($thread->path());

        $this->assertCount(1, Redis::zrevrange('trending.threads', 0, 0));
    }
}
