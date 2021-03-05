<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\EarningsSurprises;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EarningsSurprisesTest extends BaseTestCase
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
            "date" : "2021-01-27",
            "symbol" : "AAPL",
            "actualEarningResult" : 1.68,
            "estimatedEarning" : 1.41
          }, {
            "date" : "2020-10-29",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.73,
            "estimatedEarning" : 0.7
          }, {
            "date" : "2020-07-30",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.65,
            "estimatedEarning" : 0.51
          }, {
            "date" : "2020-04-30",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.64,
            "estimatedEarning" : 0.56
          }, {
            "date" : "2020-01-28",
            "symbol" : "AAPL",
            "actualEarningResult" : 1.25,
            "estimatedEarning" : 1.14
          }, {
            "date" : "2019-10-30",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.76,
            "estimatedEarning" : 0.71
          }, {
            "date" : "2019-07-30",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.55,
            "estimatedEarning" : 0.53
          }, {
            "date" : "2019-04-30",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.62,
            "estimatedEarning" : 0.59
          }, {
            "date" : "2019-01-29",
            "symbol" : "AAPL",
            "actualEarningResult" : 1.05,
            "estimatedEarning" : 1.04
          }, {
            "date" : "2018-11-01",
            "symbol" : "AAPL",
            "actualEarningResult" : 0.73,
            "estimatedEarning" : 0.7
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $earnings_surprises = new \Leijman\FmpApiSdk\CompanyValuation\EarningsSurprises($this->client);

        $this->expectException(InvalidData::class);

        $earnings_surprises->get();
    }

    /** @test */
    public function it_can_query_the_earnings_surprises_endpoint()
    {
        $earnings_surprises = new \Leijman\FmpApiSdk\CompanyValuation\EarningsSurprises($this->client);

        $response = $earnings_surprises->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
        $this->assertEquals('AAPL', $response->first()->symbol);
        $this->assertEquals(1.41, $response->first()->estimatedEarning);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EarningsSurprises::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        EarningsSurprises::setSymbol('AAPL');
    }
}
