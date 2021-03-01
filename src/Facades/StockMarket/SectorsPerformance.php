<?php

namespace Leijman\FmpApiSdk\Facades\StockMarket;

use Illuminate\Support\Facades\Facade;

class SectorsPerformance extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\StockMarket\SectorsPerformance::class;
    }
}
