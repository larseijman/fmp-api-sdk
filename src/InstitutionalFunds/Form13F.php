<?php

namespace Leijman\FmpApiSdk\InstitutionalFunds;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class Form13F extends BaseRequest
{
    const ENDPOINT = 'v3/form-thirteen/{cik}?';

    private $query_string = array();

    /**
     * @var string
     */
    private $cik;

    /**
     * @var string
     */
    private $date;

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
     * @param  string  $cik
     *
     * @return Form13F
     */
    public function setCik(string $cik): self
    {
        $this->cik = $cik;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace('{cik}', $this->cik, self::ENDPOINT);
    }

    /**
     * @param string $date
     *
     * @return Form13F
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        $this->query_string['date'] = $date;

        return $this;
    }

    /**
     * @return bool|void
     * @throws InvalidData
     */
    protected function validateParams(): void
    {
        if (empty($this->cik)) {
            throw InvalidData::invalidDataProvided('Please provide a cik to the query!');
        }

        try {
            $invalid_data_msg = 'The given date format is incorrect, expected; (\'Y-m-d\').';
            if (!empty($this->date)) {
                if (Carbon::createFromFormat('Y-m-d', $this->date)->format('Y-m-d') != $this->date) {
                    throw new InvalidFormatException($invalid_data_msg);
                }
            }
        } catch (InvalidFormatException $message) {
            throw InvalidData::invalidDataProvided($invalid_data_msg);
        }
    }
}
