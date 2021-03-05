<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\Quote;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class QuoteTest extends BaseTestCase
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
            "name" : "Apple Inc.",
            "price" : 125.35000000,
            "changesPercentage" : -0.41000000,
            "change" : -0.51000000,
            "dayLow" : 122.23000000,
            "dayHigh" : 125.56000000,
            "yearHigh" : 145.09000000,
            "yearLow" : 53.15250000,
            "marketCap" : 2104388354048.00000000,
            "priceAvg50" : 133.33353000,
            "priceAvg200" : 122.57130400,
            "volume" : 107661341,
            "avgVolume" : 104092062,
            "exchange" : "NASDAQ",
            "open" : 124.94000000,
            "previousClose" : 125.86000000,
            "eps" : 3.68700000,
            "pe" : 33.99783000,
            "earningsAnnouncement" : "2021-01-27T16:30:00.000+0000",
            "sharesOutstanding" : 16788100152,
            "timestamp" : 1614204520
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $quote = new \Leijman\FmpApiSdk\CompanyValuation\Quote($this->client);

        $this->expectException(InvalidData::class);

        $quote->get();
    }

    /** @test */
    public function it_can_query_the_quote_endpoint()
    {
        $quote = new \Leijman\FmpApiSdk\CompanyValuation\Quote($this->client);

        $response = $quote->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(22, $response);
        $this->assertEquals('AAPL', $response['symbol']);
        $this->assertEquals(104092062, $response['avgVolume']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Quote::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Quote::setSymbol('AAPL');
    }
}
