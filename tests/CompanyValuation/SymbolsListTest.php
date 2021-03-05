<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\CompanyValuation\SymbolsList;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class SymbolsListTest extends BaseTestCase
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
            "symbol" : "SPY",
            "name" : "SPDR S&P 500",
            "price" : 391.77,
            "exchange" : "NYSE Arca"
          }, {
            "symbol" : "CMCSA",
            "name" : "Comcast Corp",
            "price" : 53.4,
            "exchange" : "Nasdaq Global Select"
          }, {
            "symbol" : "KMI",
            "name" : "Kinder Morgan Inc",
            "price" : 15.72,
            "exchange" : "New York Stock Exchange"
          }, {
            "symbol" : "INTC",
            "name" : "Intel Corp",
            "price" : 63.19,
            "exchange" : "Nasdaq Global Select"
          }, {
            "symbol" : "MU",
            "name" : "Micron Technology Inc",
            "price" : 92.52,
            "exchange" : "Nasdaq Global Select"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_symbols_list_endpoint()
    {
        $symbols_list = new \Leijman\FmpApiSdk\CompanyValuation\SymbolsList($this->client);

        $response = $symbols_list->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
        $this->assertEquals('Micron Technology Inc', $response->last()->name);
        $this->assertEquals(92.52, $response->last()->price);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SymbolsList::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = SymbolsList::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
    }
}
