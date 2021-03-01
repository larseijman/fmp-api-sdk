<?php

namespace Leijman\FmpApiSdk\Tests\StockMarket;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\StockMarket\Gainers;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class GainersTest extends BaseTestCase
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
            "ticker" : "DIVC",
            "changes" : 6.9196,
            "price" : "30.9196",
            "changesPercentage" : "(+28.83%)",
            "companyName" : "Citigroup Inc. C-Tracks ETN Miller/Howard Strategic Dividend Reinvestors Due 9/16/2014"
          }, {
            "ticker" : "AFI",
            "changes" : 1.14,
            "price" : "5.18",
            "changesPercentage" : "(+28.22%)",
            "companyName" : "Armstrong Flooring Inc"
          }, {
            "ticker" : "PIC",
            "changes" : 4.22,
            "price" : "19.54",
            "changesPercentage" : "(+27.55%)",
            "companyName" : "Pivotal Investment Corporation II"
          }, {
            "ticker" : "OILD",
            "changes" : 9.32,
            "price" : "45.32",
            "changesPercentage" : "(+25.89%)",
            "companyName" : "ProShares UltraPro 3x Short Crude Oil"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_gainers_endpoint()
    {
        $gainers = new \Leijman\FmpApiSdk\StockMarket\Gainers($this->client);

        $response = $gainers->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('OILD', $response->last()->ticker);
        $this->assertEquals('ProShares UltraPro 3x Short Crude Oil', $response->last()->companyName);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Gainers::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Gainers::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
