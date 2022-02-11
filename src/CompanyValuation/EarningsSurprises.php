<?php

namespace Leijman\FmpApiSdk\CompanyValuation;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class EarningsSurprises extends BaseRequest
{
    const ENDPOINT = 'v3/earnings-surpises/{symbol}';

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
        return str_replace('{symbol}', $this->symbol, self::ENDPOINT);
    }

    /**
     * @return bool|void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if (empty($this->symbol)) {
            throw InvalidData::invalidDataProvided('Please provide a symbol to query!');
        }
    }
}
