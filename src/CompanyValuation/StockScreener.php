<?php

namespace Leijman\FmpApiSdk\CompanyValuation;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class StockScreener extends BaseRequest
{
    const ENDPOINT = 'stock-screener?';

    public $query_string = array();

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
        return self::ENDPOINT.http_build_query($this->query_string);
    }

    /**
     * @param string $exchanges
     * 
     * @return StockScreener
     */
    public function setExchange(string $exchanges): self
    {
        array_push($this->query_string, ['exchange' => $exchanges]);

        return $this;
    }

    /**
     * @param bool $is_actively_trading
     * 
     * @return StockScreener
     */
    public function setIsActivelyTrading(bool $is_actively_trading): self
    {
        array_push($this->query_string, ['isActivelyTrading' => $is_actively_trading]);

        return $this;
    }
}