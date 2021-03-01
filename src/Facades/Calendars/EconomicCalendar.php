<?php

namespace Leijman\FmpApiSdk\Facades\Calendars;

use Illuminate\Support\Facades\Facade;

class EconomicCalendar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\Calendars\EconomicCalendar::class;
    }
}
