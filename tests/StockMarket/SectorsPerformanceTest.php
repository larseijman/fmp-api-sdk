<?php

namespace Leijman\FmpApiSdk\Tests\StockMarket;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\StockMarket\SectorsPerformance;
use Leijman\FmpApiSdk\Tests\BaseTestCase;
use TypeError;

class SectorsPerformanceTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
            "stockExchangeName" : "New York Stock Exchange",
            "stockMarketHours" : {
              "openingHour" : "09:30 a.m. ET",
              "closingHour" : "04:00 p.m. ET"
            },
            "stockMarketHolidays" : [ {
              "year" : 2019,
              "New Years Day" : "2019-01-01",
              "Martin Luther King, Jr. Day" : "2019-01-21",
              "Washington\'s Birthday" : "2019-02-18",
              "Good Friday" : "2019-04-19",
              "Memorial Day" : "2019-05-27",
              "Independence Day" : "2019-07-04",
              "Labor Day" : "2019-09-02",
              "Thanksgiving Day" : "2019-11-28",
              "Christmas" : "2019-12-25"
            }, {
              "year" : 2020,
              "New Years Day" : "2020-01-01",
              "Martin Luther King, Jr. Day" : "2020-01-20",
              "Washington\'s Birthday" : "2020-02-17",
              "Good Friday" : "2020-04-10",
              "Memorial Day" : "2020-05-25",
              "Independence Day" : "2020-07-03",
              "Labor Day" : "2020-09-07",
              "Thanksgiving Day" : "2020-11-26",
              "Christmas" : "2020-12-25"
            }, {
              "year" : 2021,
              "New Years Day" : "2021-01-01",
              "Martin Luther King, Jr. Day" : "2021-01-18",
              "Washington\'s Birthday" : "2021-02-15",
              "Good Friday" : "2021-04-02",
              "Memorial Day" : "2021-05-31",
              "Independence Day" : "2021-07-05",
              "Labor Day" : "2021-09-06",
              "Thanksgiving Day" : "2021-11-25",
              "Christmas" : "2021-12-24"
            }, {
              "year" : 2022,
              "New Years Day" : "2022-01-01",
              "Martin Luther King, Jr. Day" : "2022-01-17",
              "Washington\'s Birthday" : "2022-02-21",
              "Good Friday" : "2022-04-15",
              "Memorial Day" : "2022-05-30",
              "Independence Day" : "2022-07-04",
              "Labor Day" : "2022-09-05",
              "Thanksgiving Day" : "2022-11-24",
              "Christmas" : "2022-12-26"
            } ],
            "isTheStockMarketOpen" : true,
            "isTheEuronextMarketOpen" : true,
            "isTheForexMarketOpen" : true,
            "isTheCryptoMarketOpen" : true
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_sectors_performance_endpoint()
    {
        $sectors_performance = new \Leijman\FmpApiSdk\StockMarket\SectorsPerformance($this->client);

        $response = $sectors_performance->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(7, $response);
        $this->assertEquals('2022-12-26', $response['stockMarketHolidays'][3]->Christmas);
        $this->assertEquals(true, $response['isTheEuronextMarketOpen']);
    }

    /** @test */
    public function it_can_set_a_limit()
    {
        $sectors_performance = new \Leijman\FmpApiSdk\StockMarket\SectorsPerformance($this->client);

        $response = $sectors_performance->setLimit(3)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(7, $response);
    }

    /** @test */
    public function it_should_fail_when_the_limit_is_not_an_integer()
    {
        $sectors_performance = new \Leijman\FmpApiSdk\StockMarket\SectorsPerformance($this->client);

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('must be of type int, string given');

        $sectors_performance->setLimit('abc')
            ->get();
    }

    /** @test */
    public function it_can_set_historical_get()
    {
        $sectors_performance = new \Leijman\FmpApiSdk\StockMarket\SectorsPerformance($this->client);

        $response = $sectors_performance->historical()
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(7, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SectorsPerformance::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = SectorsPerformance::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(7, $response);
        $this->assertEquals(2019, $response['stockMarketHolidays'][0]->year);
        $this->assertEquals(true, $response['isTheEuronextMarketOpen']);
    }
}
