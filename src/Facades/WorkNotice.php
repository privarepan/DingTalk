<?php

namespace ThinkCar\DingTalk\Facades;

use Illuminate\Support\Facades\Facade;

class WorkNotice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ding.work-notice';
    }
}
