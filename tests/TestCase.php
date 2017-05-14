<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected function signIn(App\User $user = null)
    {
        $user = $user ?: create('App\User');
        $this->be($user);
        return $this;
    }
}
