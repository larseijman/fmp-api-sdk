<?php

namespace Leijman\FmpApiSdk\Facades\InstitutionalFunds;

use Illuminate\Support\Facades\Facade;

class EtfSectorWeightings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\InstitutionalFunds\EtfSectorWeightings::class;
    }
}
