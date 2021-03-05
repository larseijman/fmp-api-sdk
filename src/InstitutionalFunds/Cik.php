<?php

namespace Leijman\FmpApiSdk\InstitutionalFunds;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class Cik extends BaseRequest
{
    const ENDPOINT = 'cik/{cik}';

    /**
     * @var string
     */
    private $id;

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
        return str_replace('{cik}', $this->id, self::ENDPOINT);
    }

    /**
     * @param string $id
     *
     * @return Cik
     */
    public function setCik(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool|void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if (empty($this->id)) {
            throw InvalidData::invalidDataProvided('Please provide a CIK code to the query!');
        }
    }
}
