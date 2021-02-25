<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\MarketCapitalization;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class MarketCapitalizationTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
            "symbol" : "AAPL",
            "date" : "2021-02-24",
            "marketCap" : 2145200790800
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $market_capitalization = new \Leijman\FmpApiSdk\CompanyValuation\MarketCapitalization($this->client);

        $this->expectException(InvalidData::class);

        $market_capitalization->get();
    }

    /** @test */
    public function it_can_query_the_market_capitalization_endpoint()
    {
        $market_capitalization = new \Leijman\FmpApiSdk\CompanyValuation\MarketCapitalization($this->client);

        $response = $market_capitalization->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('AAPL', $response['symbol']);
        $this->assertEquals(2145200790800, $response['marketCap']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        MarketCapitalization::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        MarketCapitalization::setSymbol('AAPL');
    }
}