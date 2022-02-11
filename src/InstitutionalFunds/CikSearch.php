<?php

namespace Leijman\FmpApiSdk\InstitutionalFunds;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class CikSearch extends BaseRequest
{
    const ENDPOINT = 'v3/cik-search/{name}';

    /**
     * @var string
     */
    private $name;

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
        return str_replace('{name}', $this->name, self::ENDPOINT);
    }

    /**
     * @param string $name
     *
     * @return CikSearch
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool|void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if (empty($this->name)) {
            throw InvalidData::invalidDataProvided('Please provide a name to the query!');
        }
    }
}
