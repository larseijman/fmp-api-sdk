<?php

namespace Leijman\FmpApiSdk\InstitutionalFunds;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class CusipMapper extends BaseRequest
{
    const ENDPOINT = 'v3/cusip/{cusip}';

    /**
     * @var string
     */
    private $cusip;

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
        return str_replace('{cusip}', $this->cusip, self::ENDPOINT);
    }

    /**
     * @param string $cusip
     *
     * @return CusipMapper
     */
    public function setCusip(string $cusip): self
    {
        $this->cusip = $cusip;

        return $this;
    }

    /**
     * @return bool|void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if (empty($this->cusip)) {
            throw InvalidData::invalidDataProvided('Please provide a cusip to the query!');
        }
    }
}
