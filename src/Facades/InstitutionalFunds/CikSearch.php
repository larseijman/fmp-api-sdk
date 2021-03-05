<?php

namespace Leijman\FmpApiSdk\Facades\InstitutionalFunds;

use Illuminate\Support\Facades\Facade;

class CikSearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\InstitutionalFunds\CikSearch::class;
    }
}
