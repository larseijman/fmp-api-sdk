<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\EtfCountryWeightings;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EtfCountryWeightingsTest extends BaseTestCase
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
            "country" : "United States",
            "weightPercentage" : "100.00%"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $etf_country_weightings = new \Leijman\FmpApiSdk\InstitutionalFunds\EtfCountryWeightings($this->client);

        $this->expectException(InvalidData::class);

        $etf_country_weightings->get();
    }

    /** @test */
    public function it_can_query_the_etf_country_weightings_endpoint()
    {
        $etf_country_weightings = new \Leijman\FmpApiSdk\InstitutionalFunds\EtfCountryWeightings($this->client);

        $response = $etf_country_weightings->setSymbol('SPY')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
        $this->assertEquals('United States', $response->last()->country);
        $this->assertEquals('100.00%', $response->last()->weightPercentage);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EtfCountryWeightings::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        EtfCountryWeightings::setSymbol('SPY');
    }
}
