<?php

namespace Leijman\FmpApiSdk\StockMarket;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class Actives extends BaseRequest
{
    const ENDPOINT = 'actives';

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
