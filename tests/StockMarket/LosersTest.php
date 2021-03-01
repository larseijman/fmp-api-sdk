<?php

namespace Leijman\FmpApiSdk\Tests\StockMarket;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\StockMarket\Losers;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class LosersTest extends BaseTestCase
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
            "ticker" : "IDXG",
            "changes" : -0.92,
            "price" : "3",
            "changesPercentage" : "(-23.47%)",
            "companyName" : "Interpace Biosciences Inc"
          }, {
            "ticker" : "AMJL",
            "changes" : -0.3557,
            "price" : "1.2",
            "changesPercentage" : "(-22.86%)",
            "companyName" : "Credit Suisse X-Links Monthly Pay 2xLeveraged Alerian MLP Index Exchange Traded Notes due May 16 2036"
          }, {
            "ticker" : "KOSS",
            "changes" : -4.82,
            "price" : "16.71",
            "changesPercentage" : "(-22.39%)",
            "companyName" : "Koss Corp"
          }, {
            "ticker" : "WINS",
            "changes" : -4.09,
            "price" : "14.21",
            "changesPercentage" : "(-22.35%)",
            "companyName" : "Wins Finance Holdings Inc"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_losers_endpoint()
    {
        $losers = new \Leijman\FmpApiSdk\StockMarket\Losers($this->client);

        $response = $losers->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('(-22.35%)', $response->last()->changesPercentage);
        $this->assertEquals('Wins Finance Holdings Inc', $response->last()->companyName);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Losers::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Losers::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
