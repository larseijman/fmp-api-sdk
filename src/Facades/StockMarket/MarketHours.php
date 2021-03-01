<?php

namespace Leijman\FmpApiSdk\Facades\StockMarket;

use Illuminate\Support\Facades\Facade;

class MarketHours extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\StockMarket\MarketHours::class;
    }
}
