<?php

namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Visits
 */
class Visits
{
    protected $thread;

    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?: 0;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());
    }

    protected function cacheKey()
    {
        return app()->environment('testing') ? "testing.thread.{$this->thread->id}" : "thread.{$this->thread->id}";
    }
}
