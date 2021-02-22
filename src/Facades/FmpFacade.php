<?php

namespace Leijman\FmpApiSdk\Facades;

use Illuminate\Support\Facades\Facade;

class FmpFacade extends Facade
{
    protected static function getFacadeAccessor() 
    {
        return 'fmp';
    }
}