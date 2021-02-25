<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\CompanyValuation\EtfsList;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class EtfsListTest extends BaseTestCase
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
            "symbol" : "GDX",
            "name" : "VanEck Vectors Gold Miners",
            "price" : 33.7,
            "exchange" : "NYSE Arca"
          }, {
            "symbol" : "EEM",
            "name" : "iShares MSCI Emerging Index Fund",
            "price" : 55.73,
            "exchange" : "NYSE Arca"
          }, {
            "symbol" : "EFA",
            "name" : "iShares MSCI EAFE",
            "price" : 76.37,
            "exchange" : "NYSE Arca"
          }, {
            "symbol" : "QQQ",
            "name" : "PowerShares QQQ Trust Series 1",
            "price" : 324.13,
            "exchange" : "NASDAQ Global Market"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_etfs_list_endpoint()
    {
        $etfs_list = new \Leijman\FmpApiSdk\CompanyValuation\EtfsList($this->client);

        $response = $etfs_list->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
        $this->assertEquals('SPY', $response->first()->symbol);
        $this->assertEquals(391.77, $response->first()->price);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        EtfsList::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = EtfsList::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
    }
}
