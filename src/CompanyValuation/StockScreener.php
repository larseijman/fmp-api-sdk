<?php

namespace Leijman\FmpApiSdk\CompanyValuation;

use Leijman\FmpApiSdk\Contracts\Fmp;
use Leijman\FmpApiSdk\Requests\BaseRequest;

class StockScreener extends BaseRequest
{
    const ENDPOINT = 'stock-screener?';

    public $query_string = array();

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
     * @param int $market_cap_more_than
     *
     * @return StockScreener
     */
    public function setMarketCapMoreThan(int $market_cap_more_than): self
    {
        array_push($this->query_string, ['marketCapMoreThan' => $market_cap_more_than]);

        return $this;
    }

    /**
     * @param int $market_cap_lower_than
     *
     * @return StockScreener
     */
    public function setMarketCapLowerThan(int $market_cap_lower_than): self
    {
        array_push($this->query_string, ['marketCapLowerThan' => $market_cap_lower_than]);

        return $this;
    }

    /**
     * @param int $price_more_than
     *
     * @return StockScreener
     */
    public function setPriceMoreThan(int $price_more_than): self
    {
        array_push($this->query_string, ['priceMoreThan' => $price_more_than]);

        return $this;
    }

    /**
     * @param int $price_lower_than
     *
     * @return StockScreener
     */
    public function setPriceLowerThan(int $price_lower_than): self
    {
        array_push($this->query_string, ['priceLowerThan' => $price_lower_than]);

        return $this;
    }

    /**
     * @param int $beta_more_than
     *
     * @return StockScreener
     */
    public function setBetaMoreThan(int $beta_more_than): self
    {
        array_push($this->query_string, ['betaMoreThan' => $beta_more_than]);

        return $this;
    }

    /**
     * @param int $beta_lower_than
     *
     * @return StockScreener
     */
    public function setBetaLowerThan(int $beta_lower_than): self
    {
        array_push($this->query_string, ['betaLowerThan' => $beta_lower_than]);

        return $this;
    }

    /**
     * @param int $volume_more_than
     *
     * @return StockScreener
     */
    public function setVolumeMoreThan(int $volume_more_than): self
    {
        array_push($this->query_string, ['volumeMoreThan' => $volume_more_than]);

        return $this;
    }

    /**
     * @param int $volume_lower_than
     *
     * @return StockScreener
     */
    public function setVolumeLowerThan(int $volume_lower_than): self
    {
        array_push($this->query_string, ['volumeLowerThan' => $volume_lower_than]);

        return $this;
    }

    /**
     * @param int $dividend_more_than
     *
     * @return StockScreener
     */
    public function setDividendMoreThan(int $dividend_more_than): self
    {
        array_push($this->query_string, ['dividendMoreThan' => $dividend_more_than]);

        return $this;
    }

    /**
     * @param int $dividend_lower_than
     *
     * @return StockScreener
     */
    public function setDividendLowerThan(int $dividend_lower_than): self
    {
        array_push($this->query_string, ['dividendLowerThan' => $dividend_lower_than]);

        return $this;
    }

    /**
     * @param string $exchanges
     *
     * @return StockScreener
     */
    public function setExchange(string $exchanges): self
    {
        array_push($this->query_string, ['exchange' => $exchanges]);

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return StockScreener
     */
    public function setLimit(int $limit): self
    {
        array_push($this->query_string, ['limit' => $limit]);

        return $this;
    }

    /**
     * @param string $countries
     *
     * @return StockScreener
     */
    public function setCountries(string $countries): self
    {
        array_push($this->query_string, ['country' => $countries]);

        return $this;
    }

    /**
     * @param string $industries
     *
     * @return StockScreener
     */
    public function setIndustries(string $industries): self
    {
        array_push($this->query_string, ['industry' => $industries]);

        return $this;
    }

    /**
     * @param string $sectors
     *
     * @return StockScreener
     */
    public function setSectors(string $sectors): self
    {
        array_push($this->query_string, ['sector' => $sectors]);

        return $this;
    }

    /**
     * @param bool $is_actively_trading
     *
     * @return StockScreener
     */
    public function setIsActivelyTrading(bool $is_actively_trading): self
    {
        array_push($this->query_string, ['isActivelyTrading' => $is_actively_trading]);

        return $this;
    }

    /**
     * @param bool $is_etf
     *
     * @return StockScreener
     */
    public function setIsEtf(bool $is_etf): self
    {
        array_push($this->query_string, ['isEtf' => $is_etf]);

        return $this;
    }
}
