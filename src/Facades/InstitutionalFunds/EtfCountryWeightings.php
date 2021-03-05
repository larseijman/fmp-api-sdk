<?php

namespace Leijman\FmpApiSdk\Facades\InstitutionalFunds;

use Illuminate\Support\Facades\Facade;

class EtfCountryWeightings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leijman\FmpApiSdk\InstitutionalFunds\EtfCountryWeightings::class;
    }
}
