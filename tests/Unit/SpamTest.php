<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->spam = new Spam();
    }

    public function test_it_checks_for_invalid_keywords()
    {
        $this->assertFalse($this->spam->detect('Innocent reply here.'));
        $this->expectException(\Exception::class);
        $this->spam->detect('yahoo customer support');
    }

    public function test_it_checks_for_keys_being_held_dowm()
    {
        $this->expectException(\Exception::class);
        $this->spam->detect('aaaaaaaaa');
    }
}
