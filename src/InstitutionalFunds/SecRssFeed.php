<?php

namespace Leijman\FmpApiSdk\InstitutionalFunds;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class SecRssFeed extends BaseRequest
{
    const ENDPOINT = 'rss_feeds?';

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
        return self::ENDPOINT;
    }

    /**
     * @param int $limit
     *
     * @return SecRssFeed
     */
    public function setLimit(int $limit): self
    {
        array_push($this->query_string, ['limit' => $limit]);

        return $this;
    }
}
