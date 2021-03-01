<?php

namespace Leijman\FmpApiSdk\Tests\Calendars;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\Calendars\EconomicCalendar;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EconomicCalendarTest extends BaseTestCase
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
            "event" : "United States exinspect Export Corn Inspected",
            "date" : "2020-10-19 15:00:00",
            "country" : "US",
            "actual" : 911.012,
            "previous" : 632.184,
            "change" : 278.828,
            "changePercentage" : 0.4411,
            "estimate" : null
          }, {
            "event" : "United States exinspect Export Wheat Inspected",
            "date" : "2020-10-19 15:00:00",
            "country" : "US",
            "actual" : 239.688,
            "previous" : 514.086,
            "change" : -274.398,
            "changePercentage" : -0.5338,
            "estimate" : null
          }, {
            "event" : "Canada Survey Business Outlook Future Sales",
            "date" : "2020-10-19 14:30:00",
            "country" : "CA",
            "actual" : 39,
            "previous" : -35,
            "change" : 74,
            "changePercentage" : 2.1143,
            "estimate" : null
          }, {
            "event" : "United States NAHB housing market NAHB Housing Market Indx",
            "date" : "2020-10-19 14:00:00",
            "country" : "US",
            "actual" : 85,
            "previous" : 83,
            "change" : 2,
            "changePercentage" : 0.0241,
            "estimate" : 83
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_economic_calendar_endpoint()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $response = $economic_calendar
            ->setFromDate($from)
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('United States NAHB housing market NAHB Housing Market Indx', $response->last()->event);
        $this->assertEquals('0.0241', $response->last()->changePercentage);
    }

    /** @test */
    public function it_can_query_the_from_date_economic_calendar_endpoint()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $economic_calendar
            ->setFromDate($from)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('United States NAHB housing market NAHB Housing Market Indx', $response->last()->event);
        $this->assertEquals('0.0241', $response->last()->changePercentage);
    }

    /** @test */
    public function it_can_query_the_to_date_economic_calendar_endpoint()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $to = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $economic_calendar
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('United States NAHB housing market NAHB Housing Market Indx', $response->last()->event);
        $this->assertEquals('0.0241', $response->last()->changePercentage);
    }

    /** @test */
    public function it_should_fail_when_the_to_date_has_an_incorrect_format()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('d-m-Y');
        $economic_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_from_date_has_an_incorrect_format()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('d-m-Y');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $economic_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_negative()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('time interval can\'t be negative');

        $from = Carbon::now()->subMonth(12)->format('Y-m-d');
        $to = Carbon::now()->subMonth(13)->format('Y-m-d');
        $economic_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_more_than_three()
    {
        $economic_calendar = new \Leijman\FmpApiSdk\Calendars\EconomicCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('maximum time interval is 3 months');

        $from = Carbon::now()->subMonths(4)->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        $economic_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EconomicCalendar::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = EconomicCalendar::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
