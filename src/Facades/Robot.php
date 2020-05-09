<?php

namespace ThinkCar\DingTalk\Facades;

use Illuminate\Support\Facades\Facade;

class Robot extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ding.robot';
    }
}
