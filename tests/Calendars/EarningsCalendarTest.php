<?php

namespace Leijman\FmpApiSdk\Tests\Calendars;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\Calendars\EarningsCalendar;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EarningsCalendarTest extends BaseTestCase
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
            "date" : "2010-03-10",
            "symbol" : "ASPS",
            "eps" : 0.25,
            "epsEstimated" : 0.340000000000000024,
            "time" : "bmo",
            "revenue" : 56300000,
            "revenueEstimated" : 76568000
          }, {
            "date" : "2010-03-10",
            "symbol" : "CLNE",
            "eps" : -0.0299999999999999989,
            "epsEstimated" : -0.0400000000000000008,
            "time" : "amc",
            "revenue" : 42203276000000,
            "revenueEstimated" : 56271034666666.6719
          }, {
            "date" : "2010-03-10",
            "symbol" : "DSGX",
            "eps" : 0.0800000000000000017,
            "epsEstimated" : 0.0800000000000000017,
            "time" : "bmo",
            "revenue" : 0,
            "revenueEstimated" : 0
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_earnings_calendar_endpoint()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $response = $earnings_calendar
            ->setFromDate($from)
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('2010-03-10', $response->last()->date);
        $this->assertEquals('DSGX', $response->last()->symbol);
    }

    /** @test */
    public function it_can_query_the_from_date_earnings_calendar_endpoint()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $earnings_calendar
            ->setFromDate($from)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('2010-03-10', $response->last()->date);
        $this->assertEquals('DSGX', $response->last()->symbol);
    }

    /** @test */
    public function it_can_query_the_to_date_earnings_calendar_endpoint()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $to = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $earnings_calendar
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('2010-03-10', $response->last()->date);
        $this->assertEquals('DSGX', $response->last()->symbol);
    }

    /** @test */
    public function it_should_fail_when_the_to_date_has_an_incorrect_format()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('d-m-Y');
        $earnings_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_from_date_has_an_incorrect_format()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('d-m-Y');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $earnings_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_negative()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('time interval can\'t be negative');

        $from = Carbon::now()->subMonth(12)->format('Y-m-d');
        $to = Carbon::now()->subMonth(13)->format('Y-m-d');
        $earnings_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_more_than_three()
    {
        $earnings_calendar = new \Leijman\FmpApiSdk\Calendars\EarningsCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('maximum time interval is 3 months');

        $from = Carbon::now()->subMonths(4)->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        $earnings_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EarningsCalendar::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = EarningsCalendar::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
    }
}
