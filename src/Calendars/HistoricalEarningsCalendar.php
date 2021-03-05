<?php

namespace Leijman\FmpApiSdk\Calendars;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class HistoricalEarningsCalendar extends BaseRequest
{
    const ENDPOINT = 'historical/earning_calendar/{symbol}?';

    private $query_string = array();

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
     * @param int $limit
     *
     * @return HistoricalEarningsCalendar
     */
    public function setLimit(int $limit): self
    {
        $this->query_string['limit'] = $limit;

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
