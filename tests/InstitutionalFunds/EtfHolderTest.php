<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\EtfHolder;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EtfHolderHolderTest extends BaseTestCase
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
            "asset" : "AAPL",
            "sharesNumber" : 164453500,
            "weightPercentage" : 5.98
          }, {
            "asset" : "MSFT",
            "sharesNumber" : 77798290,
            "weightPercentage" : 5.35
          }, {
            "asset" : "AMZN",
            "sharesNumber" : 4388660,
            "weightPercentage" : 4.03
          }, {
            "asset" : "FB",
            "sharesNumber" : 24737140,
            "weightPercentage" : 1.89
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $etf_holder = new \Leijman\FmpApiSdk\InstitutionalFunds\EtfHolder($this->client);

        $this->expectException(InvalidData::class);

        $etf_holder->get();
    }

    /** @test */
    public function it_can_query_the_etf_holder_endpoint()
    {
        $etf_holder = new \Leijman\FmpApiSdk\InstitutionalFunds\EtfHolder($this->client);

        $response = $etf_holder->setSymbol('SPY')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('FB', $response->last()->asset);
        $this->assertEquals(24737140, $response->last()->sharesNumber);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EtfHolder::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        EtfHolder::setSymbol('SPY');
    }
}
