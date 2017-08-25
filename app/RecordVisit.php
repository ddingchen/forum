<?php

namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Record Visit
 */
trait RecordVisit
{

    public function resetVisits()
    {
        Redis::del($this->cacheKey());
    }

    public function visits()
    {
        return Redis::get($this->cacheKey()) ?: 0;
    }

    public function recordVisit()
    {
        Redis::incr($this->cacheKey());
    }

    protected function cacheKey()
    {
        return app()->environment('testing') ? "testing.thread.{$this->id}" : "thread.{$this->id}";
    }

}
