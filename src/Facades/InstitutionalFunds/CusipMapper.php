<?php

namespace Leijman\FmpApiSdk\Facades\InstitutionalFunds;

use Illuminate\Support\Facades\Facade;

class CusipMapper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\InstitutionalFunds\CusipMapper::class;
    }
}
