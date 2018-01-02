<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchThreadTest extends TestCase
{
    
    public function test_a_user_can_search_thread()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create(Thread::class, [], 2);
        create(Thread::class, ['body' => "A thread with the {$search} term,"], 2);

        $result = $this->getJson('thread/search?q=' . $search)->json();

        $this->assertCount(2, $result['data']);
    }

}
