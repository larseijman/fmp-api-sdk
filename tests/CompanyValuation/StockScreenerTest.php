<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\StockScreener;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class StockScreenerTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{
            "symbol" : "ADSK",
            "companyName" : "Autodesk Inc",
            "marketCap" : 64873849000,
            "sector" : "Technology",
            "industry" : "Software Application",
            "beta" : 1.44470000000000009521272659185342490673065185546875,
            "price" : 295.029999999999972715158946812152862548828125,
            "lastAnnualDividend" : 0,
            "volume" : 1414757,
            "exchange" : "Nasdaq Global Select",
            "exchangeShortName" : "NASDAQ",
            "country" : "US",
            "isEtf" : false,
            "isActivelyTrading" : true
          }, {
            "symbol" : "WDAY",
            "companyName" : "Workday Inc",
            "marketCap" : 63076803000,
            "sector" : "Technology",
            "industry" : "Software Application",
            "beta" : 1.5783199999999999452171550728962756693363189697265625,
            "price" : 262.81999999999999317878973670303821563720703125,
            "lastAnnualDividend" : 0,
            "volume" : 2096368,
            "exchange" : "Nasdaq Global Select",
            "exchangeShortName" : "NASDAQ",
            "country" : "US",
            "isEtf" : false,
            "isActivelyTrading" : true
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_stock_screener_endpoint()
    {
        $stock_screener = new \Leijman\FmpApiSdk\CompanyValuation\StockScreener($this->client);

        $response = $stock_screener->setExchange('NASDAQ,EURONEXT')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('Workday Inc', $response->last()->companyName);
        $this->assertEquals('WDAY', $response->last()->symbol);
    }

    /** @test */
    public function it_can_chain_query_the_stock_screener_endpoint()
    {
        $stock_screener = new \Leijman\FmpApiSdk\CompanyValuation\StockScreener($this->client);

        $response = $stock_screener->setExchange('NASDAQ,EURONEXT')
            ->setLimit(2)
            ->setBetaLowerThan(2)
            ->setBetaMoreThan(1)
            ->setCountries('NL')
            ->setDividendLowerThan(2)
            ->setDividendMoreThan(0)
            ->setIndustries('Autos,Banks')
            ->setIsActivelyTrading(true)
            ->setIsEtf(false)
            ->setMarketCapLowerThan(1382174560000)
            ->setMarketCapMoreThan(104324001)
            ->setPriceLowerThan(10)
            ->setPriceMoreThan(5)
            ->setVolumeLowerThan(100000)
            ->setVolumeMoreThan(1000)
            ->setExchange('EURONEXT')
            ->setSectors('Energy,Technology')
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('Workday Inc', $response->last()->companyName);
        $this->assertEquals('WDAY', $response->last()->symbol);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        StockScreener::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = StockScreener::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
    }
}
