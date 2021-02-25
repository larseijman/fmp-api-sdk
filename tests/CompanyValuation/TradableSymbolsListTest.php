<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\CompanyValuation\TradableSymbolsList;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class TradableSymbolsListTest extends BaseTestCase
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
            "symbol" : "HPQ",
            "name" : "HP Inc",
            "price" : 27.97,
            "exchange" : "New York Stock Exchange"
          }, {
            "symbol" : "CX",
            "name" : "Cemex S.A.B. de C.V. Sponsored ADR",
            "price" : 6.9,
            "exchange" : "New York Stock Exchange"
          }, {
            "symbol" : "EFA",
            "name" : "iShares MSCI EAFE",
            "price" : 76.37,
            "exchange" : "NYSE Arca"
          }, {
            "symbol" : "CZR",
            "name" : "Caesars Entertainment Inc",
            "price" : 89.96,
            "exchange" : "Nasdaq Global Select"
          }, {
            "symbol" : "QQQ",
            "name" : "PowerShares QQQ Trust Series 1",
            "price" : 324.13,
            "exchange" : "NASDAQ Global Market"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_tradable_symbols_list_endpoint()
    {
        $tradable_symbols_list = new \Leijman\FmpApiSdk\CompanyValuation\TradableSymbolsList($this->client);

        $response = $tradable_symbols_list->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
        $this->assertEquals('PowerShares QQQ Trust Series 1', $response->last()->name);
        $this->assertEquals(324.13, $response->last()->price);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        TradableSymbolsList::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = TradableSymbolsList::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
    }
}