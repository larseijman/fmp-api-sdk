<?php

namespace Leijman\FmpApiSdk\Facades\Exchanges;

use Illuminate\Support\Facades\Facade;

class Quotes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\Exchanges\Quotes::class;
    }
}