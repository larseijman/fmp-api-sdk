<?php

namespace Leijman\FmpApiSdk\Facades\StockMarket;

use Illuminate\Support\Facades\Facade;

class Losers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\StockMarket\Losers::class;
    }
}
