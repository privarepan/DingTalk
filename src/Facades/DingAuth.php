<?php

namespace ThinkCar\DingTalk\Facades;

use Illuminate\Support\Facades\Facade;

class DingAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ding.auth';
    }
}
