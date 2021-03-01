<?php

namespace Leijman\FmpApiSdk\Facades\Calendars;

use Illuminate\Support\Facades\Facade;

class IpoCalendar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\Calendars\IpoCalendar::class;
    }
}
