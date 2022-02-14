<?php

namespace Leijman\FmpApiSdk\Misc;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class ProfileByIsin extends BaseRequest
{
    const ENDPOINT = 'v4/search/isin';

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
        return http_build_query($this->query_string);
    }

    /**
     * @param string $isin
     *
     * @return ProfileByIsin
     */
    public function setIsin(string $isin): self
    {
        $this->query_string['isin'] = $isin;

        return $this;
    }

    /**
     * @return bool|void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if (empty($this->query_string['isin'])) {
            throw InvalidData::invalidDataProvided('Please provide an isin code to query!');
        }
    }
}
