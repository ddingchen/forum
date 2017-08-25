<?php

namespace App;

use App\Thread;
use Illuminate\Support\Facades\Redis;

/**
 * Trending
 */
class Trending
{
    public function del()
    {
        Redis::del($this->key());
    }

    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->key(), 0, 4));
    }

    public function touch(Thread $thread)
    {
        Redis::zincrby($this->key(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path(),
        ]));
    }

    protected function key()
    {
        return app()->environment('testing') ? 'testing.trending.threads' : 'trending.threads';
    }
}
