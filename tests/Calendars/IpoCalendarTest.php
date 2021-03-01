<?php

namespace Leijman\FmpApiSdk\Tests\Calendars;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\Calendars\IpoCalendar;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class IpoCalendarTest extends BaseTestCase
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
            "date" : "2020-09-04",
            "label" : "September 04, 20",
            "symbol" : "GCY.AX",
            "numerator" : 1.0,
            "denominator" : 20.0
          }, {
            "date" : "2020-09-04",
            "label" : "September 04, 20",
            "symbol" : "1653.HK",
            "numerator" : 1.0,
            "denominator" : 10.0
          }, {
            "date" : "2020-09-03",
            "label" : "September 03, 20",
            "symbol" : "RE1.AX",
            "numerator" : 1.0,
            "denominator" : 2.0
          }, {
            "date" : "2020-09-03",
            "label" : "September 03, 20",
            "symbol" : "SNSS",
            "numerator" : 1.0,
            "denominator" : 10.0
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_ipo_calendar_endpoint()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $response = $ipo_calendar
            ->setFromDate($from)
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('September 03, 20', $response->last()->label);
        $this->assertEquals('SNSS', $response->last()->symbol);
    }

    /** @test */
    public function it_can_query_the_from_date_ipo_calendar_endpoint()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $ipo_calendar
            ->setFromDate($from)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('September 03, 20', $response->last()->label);
        $this->assertEquals('SNSS', $response->last()->symbol);
    }

    /** @test */
    public function it_can_query_the_to_date_ipo_calendar_endpoint()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $to = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $ipo_calendar
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('September 03, 20', $response->last()->label);
        $this->assertEquals('SNSS', $response->last()->symbol);
    }

    /** @test */
    public function it_should_fail_when_the_to_date_has_an_incorrect_format()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('d-m-Y');
        $ipo_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_from_date_has_an_incorrect_format()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('d-m-Y');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $ipo_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_negative()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('time interval can\'t be negative');

        $from = Carbon::now()->subMonth(12)->format('Y-m-d');
        $to = Carbon::now()->subMonth(13)->format('Y-m-d');
        $ipo_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_more_than_three()
    {
        $ipo_calendar = new \Leijman\FmpApiSdk\Calendars\IpoCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('maximum time interval is 3 months');

        $from = Carbon::now()->subMonths(4)->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        $ipo_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        IpoCalendar::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = IpoCalendar::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
