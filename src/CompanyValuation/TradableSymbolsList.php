<?php

namespace Leijman\FmpApiSdk\CompanyValuation;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class TradableSymbolsList extends BaseRequest
{
    const ENDPOINT = 'available-traded/list';

    /**
     * Create constructor.
     *
     * @param  Fmp  $api
     */
    public function __construct(Fmp $api)
    {
        parent::__construct($api);
    }

    /**
     *
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return self::ENDPOINT;
    }
}