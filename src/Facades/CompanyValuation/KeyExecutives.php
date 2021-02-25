<?php

namespace Leijman\FmpApiSdk\Facades\CompanyValuation;

use Illuminate\Support\Facades\Facade;

class KeyExecutives extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\CompanyValuation\KeyExecutives::class;
    }
}