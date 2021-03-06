<?php

namespace Leijman\FmpApiSdk\Facades\Calendars;

use Illuminate\Support\Facades\Facade;

class StockSplitCalendar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\Calendars\StockSplitCalendar::class;
    }
}
