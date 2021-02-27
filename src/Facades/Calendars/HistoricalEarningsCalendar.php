<?php

namespace Leijman\FmpApiSdk\Facades\Calendars;

use Illuminate\Support\Facades\Facade;

class HistoricalEarningsCalendar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\Calendars\HistoricalEarningsCalendar::class;
    }
}
