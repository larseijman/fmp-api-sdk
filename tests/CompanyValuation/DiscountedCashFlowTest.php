<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\DiscountedCashFlow;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class DiscountedCashFlowTest extends BaseTestCase
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
            "date" : "2021-02-25",
            "dcf" : 127.51884618136224,
            "Stock Price" : 125.35
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $discounted_cash_flow = new \Leijman\FmpApiSdk\CompanyValuation\DiscountedCashFlow($this->client);

        $this->expectException(InvalidData::class);

        $discounted_cash_flow->get();
    }

    /** @test */
    public function it_can_query_the_discounted_cash_flow_endpoint()
    {
        $discounted_cash_flow = new \Leijman\FmpApiSdk\CompanyValuation\DiscountedCashFlow($this->client);

        $response = $discounted_cash_flow->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('AAPL', $response['symbol']);
        $this->assertEquals(127.51884618136224, $response['dcf']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        DiscountedCashFlow::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        DiscountedCashFlow::setSymbol('AAPL');
    }
}