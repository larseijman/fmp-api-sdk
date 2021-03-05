<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\CikSearch;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class CikSearchTest extends BaseTestCase
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
            "cik" : "0001067983",
            "name" : " BERKSHIRE HATHAWAY"
          }, {
            "cik" : "0000949012",
            "name" : " BERKSHIRE ASSET MANAGEMENT LLC/PA "
          }, {
            "cik" : "0000949012",
            "name" : " BERKSHIRE ASSET MANAGEMENT INC/PA "
          }, {
            "cik" : "0001133742",
            "name" : " BERKSHIRE CAPITAL HOLDINGS"
          }, {
            "cik" : "0001535172",
            "name" : " Berkshire Money Management, Inc. "
          }, {
            "cik" : "0001067983",
            "name" : "BERKSHIRE HATHAWAY"
          }, {
            "cik" : "0001312988",
            "name" : "Berkshire Partners LLC"
          }, {
            "cik" : "0001133742",
            "name" : "BERKSHIRE CAPITAL HOLDINGS"
          }, {
            "cik" : "0000949012",
            "name" : "BERKSHIRE ASSET MANAGEMENT LLC/PA"
          }, {
            "cik" : "0001535172",
            "name" : "Berkshire Money Management, Inc."
          }, {
            "cik" : "0001831984",
            "name" : "Berkshire Bank"
          }, {
            "cik" : "0001831984",
            "name" : "BERKSHIRE HATHAWAY"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_name()
    {
        $cik_search = new \Leijman\FmpApiSdk\InstitutionalFunds\CikSearch($this->client);

        $this->expectException(InvalidData::class);

        $cik_search->get();
    }

    /** @test */
    public function it_can_query_the_cik_search_endpoint()
    {
        $cik_search = new \Leijman\FmpApiSdk\InstitutionalFunds\CikSearch($this->client);

        $response = $cik_search->setName('Berkshire')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(12, $response);
        $this->assertEquals('BERKSHIRE HATHAWAY', $response->last()->name);
        $this->assertEquals('0001831984', $response->last()->cik);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        CikSearch::shouldReceive('setName')
            ->once()
            ->andReturnSelf();

        CikSearch::setName('Berkshire');
    }
}


