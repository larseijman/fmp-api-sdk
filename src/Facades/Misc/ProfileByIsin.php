<?php

namespace Leijman\FmpApiSdk\Facades\Misc;

use Illuminate\Support\Facades\Facade;

class ProfileByIsin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\Misc\ProfileByIsin::class;
    }
}
