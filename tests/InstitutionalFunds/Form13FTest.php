<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\Form13F;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class Form13FTest extends BaseTestCase
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
            "date" : "2020-06-30",
            "fillingDate" : "2020-08-14",
            "acceptedDate" : "2020-08-14 16:01:47",
            "cik" : "0001067983",
            "cusip" : "037833100",
            "tickercusip" : "AAPL",
            "nameOfIssuer" : "APPLE INC",
            "shares" : 245155566,
            "titleOfClass" : "COM",
            "value" : 89432750000,
            "link" : "https://www.sec.gov/Archives/edgar/data/1067983/000095012320009058/0000950123-20-009058-index.htm",
            "finalLink" : "https://www.sec.gov/Archives/edgar/data/1067983/000095012320009058/xslForm13F_X01/960.xml"
          }, {
            "date" : "2020-06-30",
            "fillingDate" : "2020-08-14",
            "acceptedDate" : "2020-08-14 16:01:47",
            "cik" : "0001067983",
            "cusip" : "067901108",
            "tickercusip" : "ABX",
            "nameOfIssuer" : "BARRICK GOLD CORPORATION",
            "shares" : 20918701,
            "titleOfClass" : "COM",
            "value" : 563550000,
            "link" : "https://www.sec.gov/Archives/edgar/data/1067983/000095012320009058/0000950123-20-009058-index.htm",
            "finalLink" : "https://www.sec.gov/Archives/edgar/data/1067983/000095012320009058/xslForm13F_X01/960.xml"
          }, {
            "date" : "2020-06-30",
            "fillingDate" : "2020-08-14",
            "acceptedDate" : "2020-08-14 16:01:47",
            "cik" : "0001067983",
            "cusip" : "023135106",
            "tickercusip" : "AMZN",
            "nameOfIssuer" : "AMAZON COM INC",
            "shares" : 533300,
            "titleOfClass" : "COM",
            "value" : 1471279000,
            "link" : "https://www.sec.gov/Archives/edgar/data/1067983/000095012320009058/0000950123-20-009058-index.htm",
            "finalLink" : "https://www.sec.gov/Archives/edgar/data/1067983/000095012320009058/xslForm13F_X01/960.xml"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_cik()
    {
        $form13f = new \Leijman\FmpApiSdk\InstitutionalFunds\Form13F($this->client);

        $this->expectException(InvalidData::class);

        $form13f->get();
    }

    /** @test */
    public function it_can_query_the_form13f_endpoint()
    {
        $form13f = new \Leijman\FmpApiSdk\InstitutionalFunds\Form13F($this->client);

        $response = $form13f->setCik('0001067983')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('0001067983', $response->last()->cik);
        $this->assertEquals('AMAZON COM INC', $response->last()->nameOfIssuer);
    }

    /** @test */
    public function it_can_query_the_date_form13f_endpoint()
    {
        $form13f = new \Leijman\FmpApiSdk\InstitutionalFunds\Form13F($this->client);

        $date = Carbon::now()->subMonth(5)->format('Y-m-d');
        $response = $form13f->setCik('0001067983')
            ->setDate($date)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('0001067983', $response->last()->cik);
        $this->assertEquals('AMAZON COM INC', $response->last()->nameOfIssuer);
    }

    /** @test */
    public function it_should_fail_when_the_date_has_an_incorrect_format()
    {
        $form13f = new \Leijman\FmpApiSdk\InstitutionalFunds\Form13F($this->client);

        $this->expectException(InvalidData::class);
        $this->expectExceptionMessage('date format is incorrect');

        $date = Carbon::now()->subMonth(2)->format('d-m-Y');
        $form13f->setCik('0001067983')
            ->setDate($date)
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Form13F::shouldReceive('setCik')
            ->once()
            ->andReturnSelf();

        Form13F::setCik('0001067983');
    }
}


