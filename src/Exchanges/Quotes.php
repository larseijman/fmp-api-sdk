<?php

namespace Leijman\FmpApiSdk\Exchanges;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class Quotes extends BaseRequest
{
    const ENDPOINT = 'quotes/{exchange}';
    
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
        return str_replace('{exchange}', $this->symbol, self::ENDPOINT);
    }

    /**
     * @return bool|void
     * @throws WrongData
     */
    protected function validateParams(): void
    {
        if (empty($this->symbol)) {
            // throw WrongData::invalidValuesProvided('Please provide a symbol to query!');
        }
    }
}