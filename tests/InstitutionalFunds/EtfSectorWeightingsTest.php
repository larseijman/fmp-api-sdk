<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\EtfSectorWeightings;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EtfSectorWeightingsTest extends BaseTestCase
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
            "sector" : "Healthcare",
            "weightPercentage" : "13.55%"
          }, {
            "sector" : "Telecommunications Services",
            "weightPercentage" : "10.77%"
          }, {
            "sector" : "Energy",
            "weightPercentage" : "2.28%"
          }, {
            "sector" : "Basic Materials",
            "weightPercentage" : "2.27%"
          }, {
            "sector" : "Consumer Cyclicals",
            "weightPercentage" : "12.50%"
          }, {
            "sector" : "Technology",
            "weightPercentage" : "24.19%"
          }, {
            "sector" : "Financials",
            "weightPercentage" : "13.50%"
          }, {
            "sector" : "Utilities",
            "weightPercentage" : "2.76%"
          }, {
            "sector" : "Consumer Non-Cyclicals",
            "weightPercentage" : "6.97%"
          }, {
            "sector" : "Industrials",
            "weightPercentage" : "8.79%"
          }, {
            "sector" : "Real Estate",
            "weightPercentage" : "2.42%"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $etf_sector_weightings = new \Leijman\FmpApiSdk\InstitutionalFunds\EtfSectorWeightings($this->client);

        $this->expectException(InvalidData::class);

        $etf_sector_weightings->get();
    }

    /** @test */
    public function it_can_query_the_etf_sector_weightings_endpoint()
    {
        $etf_sector_weightings = new \Leijman\FmpApiSdk\InstitutionalFunds\EtfSectorWeightings($this->client);

        $response = $etf_sector_weightings->setSymbol('SPY')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(11, $response);
        $this->assertEquals('Real Estate', $response->last()->sector);
        $this->assertEquals('2.42%', $response->last()->weightPercentage);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EtfSectorWeightings::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        EtfSectorWeightings::setSymbol('SPY');
    }
}
