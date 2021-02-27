<?php

namespace Leijman\FmpApiSdk\Tests\Calendars;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\Calendars\HistoricalEarningsCalendar;
use Leijman\FmpApiSdk\Tests\BaseTestCase;
use TypeError;

class HistoricalEarningsCalendarTest extends BaseTestCase
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
            "date" : "2020-07-30",
            "symbol" : "AAPL",
            "eps" : 0.650000000000000022,
            "epsEstimated" : 0.510000000000000009,
            "time" : "amc",
            "revenue" : 59685000000,
            "revenueEstimated" : 46829769230.7692337
          }, {
            "date" : "2020-04-30",
            "symbol" : "AAPL",
            "eps" : 0.640000000000000013,
            "epsEstimated" : 0.560000000000000053,
            "time" : "amc",
            "revenue" : 58313000000,
            "revenueEstimated" : 51023875000.0000076
          }, {
            "date" : "2020-01-28",
            "symbol" : "AAPL",
            "eps" : 1.25,
            "epsEstimated" : 1.1399999999999999,
            "time" : "amc",
            "revenue" : 91819000000,
            "revenueEstimated" : 83738928000
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $quote = new \Leijman\FmpApiSdk\Calendars\HistoricalEarningsCalendar($this->client);

        $this->expectException(InvalidData::class);

        $quote->get();
    }

    /** @test */
    public function it_can_query_the_historical_earnings_calendar_endpoint()
    {
        $historical_earnings_calendar = new \Leijman\FmpApiSdk\Calendars\HistoricalEarningsCalendar($this->client);

        $response = $historical_earnings_calendar->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('AAPL', $response->last()->symbol);
        $this->assertEquals(1.25, $response->last()->eps);
    }

    /** @test */
    public function it_can_set_a_limit()
    {
        $historical_earnings_calendar = new \Leijman\FmpApiSdk\Calendars\HistoricalEarningsCalendar($this->client);

        $response = $historical_earnings_calendar->setSymbol('AAPL')
            ->setLimit(3)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('AAPL', $response->last()->symbol);
        $this->assertEquals(1.25, $response->last()->eps);
    }

    /** @test */
    public function it_should_fail_when_the_limit_is_not_an_integer()
    {
        $historical_earnings_calendar = new \Leijman\FmpApiSdk\Calendars\HistoricalEarningsCalendar($this->client);

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('must be of type int, string given');

        $historical_earnings_calendar->setSymbol('AAPL')
            ->setLimit('abc')
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        HistoricalEarningsCalendar::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        HistoricalEarningsCalendar::setSymbol('AAPL');
    }
}
