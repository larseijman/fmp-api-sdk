<?php

namespace Leijman\FmpApiSdk\CompanyValuation;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class EtfsList extends BaseRequest
{
    const ENDPOINT = 'v3/etf/list';

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
