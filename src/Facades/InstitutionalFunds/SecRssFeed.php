<?php

namespace Leijman\FmpApiSdk\Facades\InstitutionalFunds;

use Illuminate\Support\Facades\Facade;

class SecRssFeed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\InstitutionalFunds\SecRssFeed::class;
    }
}
