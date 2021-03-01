<?php

namespace Leijman\FmpApiSdk\Tests\StockMarket;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\StockMarket\Actives;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class ActivesTest extends BaseTestCase
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
            "ticker" : "SHOP",
            "changes" : 35.87,
            "price" : "1280.97",
            "changesPercentage" : "(+2.88%)",
            "companyName" : "Shopify Inc"
          }, {
            "ticker" : "AMZN",
            "changes" : 35.77,
            "price" : "3092.93",
            "changesPercentage" : "(+1.17%)",
            "companyName" : "Amazon.com Inc"
          }, {
            "ticker" : "CMG",
            "changes" : 31.26,
            "price" : "1442",
            "changesPercentage" : "(+2.22%)",
            "companyName" : "Chipotle Mexican Grill Inc"
          }, {
            "ticker" : "W",
            "changes" : 30.93,
            "price" : "288.98",
            "changesPercentage" : "(+11.99%)",
            "companyName" : "Wayfair Inc"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_actives_endpoint()
    {
        $actives = new \Leijman\FmpApiSdk\StockMarket\Actives($this->client);

        $response = $actives->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('W', $response->last()->ticker);
        $this->assertEquals('Wayfair Inc', $response->last()->companyName);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Actives::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Actives::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
