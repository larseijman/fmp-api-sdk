<?php

namespace Leijman\FmpApiSdk\Facades\StockMarket;

use Illuminate\Support\Facades\Facade;

class Actives extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\StockMarket\Actives::class;
    }
}
