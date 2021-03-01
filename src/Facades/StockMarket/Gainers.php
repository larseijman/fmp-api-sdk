<?php

namespace Leijman\FmpApiSdk\Facades\StockMarket;

use Illuminate\Support\Facades\Facade;

class Gainers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\StockMarket\Gainers::class;
    }
}
