<?php

namespace Tests;

use App\Traits\FakeData;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, FakeData;

    protected function authenticate(){
        $user = Sentinel::registerAndActivate($this->userData());
        Sentinel::authenticate($user);
    }
}
