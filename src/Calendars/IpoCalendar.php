<?php

namespace Leijman\FmpApiSdk\Calendars;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class IpoCalendar extends BaseRequest
{
    const ENDPOINT = 'ipo_calendar?';

    private $query_string = array();

    /**
     * @var string
     */
    private $fromDate;

    /**
     * @var string
     */
    private $toDate;

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
     * @param string $fromDate
     *
     * @return IpoCalendar
     */
    public function setFromDate(string $fromDate): self
    {
        $this->fromDate = $fromDate;
        $this->query_string['from'] = $fromDate;

        return $this;
    }

    /**
     * @param string $toDate
     *
     * @return IpoCalendar
     */
    public function setToDate(string $toDate): self
    {
        $this->toDate = $toDate;
        $this->query_string['to'] = $toDate;

        return $this;
    }

    /**
     * @return bool|void
     */
    protected function validateParams(): void
    {
        try {
            $invalid_data_msg = 'The given date format is incorrect, expected; (\'Y-m-d\').';
            if (!empty($this->fromDate)) {
                if (Carbon::createFromFormat('Y-m-d', $this->fromDate)->format('Y-m-d') != $this->fromDate) {
                    throw new InvalidFormatException($invalid_data_msg);
                }
            }

            if (!empty($this->toDate)) {
                if (Carbon::createFromFormat('Y-m-d', $this->toDate)->format('Y-m-d') != $this->toDate) {
                    throw new InvalidFormatException($invalid_data_msg);
                }
            }
        } catch (InvalidFormatException $message) {
            throw InvalidData::invalidDataProvided($invalid_data_msg);
        }

        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $diff_in_months = Carbon::parse($this->fromDate)->diffInMonths($this->toDate, false);
            if ($diff_in_months > 3) {
                throw InvalidData::invalidDataProvided(
                    'The maximum time interval is 3 months.'
                );
            }

            if ($diff_in_months < 0) {
                throw InvalidData::invalidDataProvided(
                    'The time interval can\'t be negative.'
                );
            }
        }
    }
}
