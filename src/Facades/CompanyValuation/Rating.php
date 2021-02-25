<?php

namespace Leijman\FmpApiSdk\Facades\CompanyValuation;

use Illuminate\Support\Facades\Facade;

class Rating extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\CompanyValuation\Rating::class;
    }
}