<?php

namespace Leijman\FmpApiSdk\CompanyValuation;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class HistoricalPriceFull extends BaseRequest
{
    const ENDPOINT = 'v3/historical-price-full/{symbol}?';

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
        return str_replace('{symbol}', $this->symbol, self::ENDPOINT) . http_build_query($this->query_string);
    }

    /**
     * @param string $date_from
     *
     * @return HistoricalPriceFull
     */
    public function setDateFrom(string $date_from): self
    {
        $this->query_string['from'] = $date_from;

        return $this;
    }

    /**
     * @param string $date_to
     *
     * @return HistoricalPriceFull
     */
    public function setDateTo(string $date_to): self
    {
        $this->query_string['to'] = $date_to;

        return $this;
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
