<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\CikList;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class CikListTest extends BaseTestCase
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
            "cik" : "0001767045",
            "name" : "Lindbrook Capital, LLC "
          }, {
            "cik" : "0000913760",
            "name" : "INTL FCSTONE INC. "
          }, {
            "cik" : "0001424322",
            "name" : "Cubic Asset Management, LLC "
          }, {
            "cik" : "0001666363",
            "name" : "Venturi Wealth Management, LLC "
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_cik_list_endpoint()
    {
        $cik_list = new \Leijman\FmpApiSdk\InstitutionalFunds\CikList($this->client);

        $response = $cik_list->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('Venturi Wealth Management, LLC ', $response->last()->name);
        $this->assertEquals('0001666363', $response->last()->cik);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        CikList::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = CikList::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
