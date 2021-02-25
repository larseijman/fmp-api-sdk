<?php

namespace Leijman\FmpApiSdk\Facades\CompanyValuation;

use Illuminate\Support\Facades\Facade;

class EtfsList extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\CompanyValuation\EtfsList::class;
    }
}