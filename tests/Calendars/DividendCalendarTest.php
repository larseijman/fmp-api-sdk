<?php

namespace Leijman\FmpApiSdk\Tests\Calendars;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\Calendars\DividendCalendar;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class DividendCalendarTest extends BaseTestCase
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
            "date" : "2020-09-10",
            "label" : "September 10, 20",
            "adjDividend" : 0.08,
            "symbol" : "PFN",
            "dividend" : 0.08,
            "recordDate" : "2020-09-11",
            "paymentDate" : "2020-10-01",
            "declarationDate" : "2020-09-01"
          }, {
            "date" : "2020-09-10",
            "label" : "September 10, 20",
            "adjDividend" : 0.013689,
            "symbol" : "S32.AX",
            "dividend" : 0.0136890000,
            "recordDate" : null,
            "paymentDate" : null,
            "declarationDate" : null
          }, {
            "date" : "2020-09-10",
            "label" : "September 10, 20",
            "adjDividend" : 0.0275,
            "symbol" : "SHJ.AX",
            "dividend" : 0.0275000000,
            "recordDate" : null,
            "paymentDate" : null,
            "declarationDate" : null
          }, {
            "date" : "2020-09-10",
            "label" : "September 10, 20",
            "adjDividend" : 0.09,
            "symbol" : "SRV.AX",
            "dividend" : 0.0900000000,
            "recordDate" : null,
            "paymentDate" : null,
            "declarationDate" : null
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_dividend_calendar_endpoint()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $response = $dividend_calendar
            ->setFromDate($from)
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('0.0900000000', $response->last()->dividend);
        $this->assertEquals('SRV.AX', $response->last()->symbol);
    }

    /** @test */
    public function it_can_query_the_from_date_dividend_calendar_endpoint()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $dividend_calendar
            ->setFromDate($from)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('0.0900000000', $response->last()->dividend);
        $this->assertEquals('SRV.AX', $response->last()->symbol);
    }

    /** @test */
    public function it_can_query_the_to_date_dividend_calendar_endpoint()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $to = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $dividend_calendar
            ->setToDate($to)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('0.0900000000', $response->last()->dividend);
        $this->assertEquals('SRV.AX', $response->last()->symbol);
    }

    /** @test */
    public function it_should_fail_when_the_to_date_has_an_incorrect_format()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('Y-m-d');
        $to = Carbon::now()->subMonth(2)->format('d-m-Y');
        $dividend_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_from_date_has_an_incorrect_format()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $from = Carbon::now()->subMonth(5)->format('d-m-Y');
        $to = Carbon::now()->subMonth(2)->format('Y-m-d');
        $dividend_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_negative()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('time interval can\'t be negative');

        $from = Carbon::now()->subMonth(12)->format('Y-m-d');
        $to = Carbon::now()->subMonth(13)->format('Y-m-d');
        $dividend_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_should_fail_when_the_date_diff_is_more_than_three()
    {
        $dividend_calendar = new \Leijman\FmpApiSdk\Calendars\DividendCalendar($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('maximum time interval is 3 months');

        $from = Carbon::now()->subMonths(4)->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        $dividend_calendar->setFromDate($from)
            ->setToDate($to)
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        DividendCalendar::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = DividendCalendar::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
