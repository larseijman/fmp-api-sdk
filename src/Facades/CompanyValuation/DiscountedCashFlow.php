<?php

namespace Leijman\FmpApiSdk\Facades\CompanyValuation;

use Illuminate\Support\Facades\Facade;

class DiscountedCashFlow extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\CompanyValuation\DiscountedCashFlow::class;
    }
}