<?php

namespace Leijman\FmpApiSdk\Facades\CompanyValuation;

use Illuminate\Support\Facades\Facade;

class TradableSymbolsList extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\CompanyValuation\TradableSymbolsList::class;
    }
}