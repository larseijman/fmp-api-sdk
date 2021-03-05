<?php

namespace Leijman\FmpApiSdk\StockMarket;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class SectorsPerformance extends BaseRequest
{
    const ENDPOINT = '{endpoint}?';

    private $query_string = array();

    /**
     * @var bool
     */
    private $historical;

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
     * @param int $limit
     *
     * @return SectorsPerformance
     */
    public function setLimit(int $limit): self
    {
        $this->query_string['limit'] = $limit;

        return $this;
    }

    /**
     * @return SectorsPerformance
     */
    public function historical(): self
    {
        $this->historical = true;
        return $this;
    }

    /**
     *
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace('{endpoint}', ($this->historical) ? 'historical-sectors-performance' : 'sectors-performance', self::ENDPOINT);
    }
}
