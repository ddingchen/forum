<?php

namespace Tests\Unit;

use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function test_a_channel_consists_of_threads()
    {
        $channel = create('App\Channel');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $channel->threads);
    }
}
