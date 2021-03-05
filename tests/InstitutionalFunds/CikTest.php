<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\Cik;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class CikTest extends BaseTestCase
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
            "name" : "BERKSHIRE HATHAWAY"
          }, {
            "cik" : "0001067983",
            "name" : "BERKSHIRE HATHAWAY"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_cik()
    {
        $cik = new \Leijman\FmpApiSdk\InstitutionalFunds\Cik($this->client);

        $this->expectException(InvalidData::class);

        $cik->get();
    }

    /** @test */
    public function it_can_query_the_cik_endpoint()
    {
        $cik = new \Leijman\FmpApiSdk\InstitutionalFunds\Cik($this->client);

        $response = $cik->setCik('0001067983')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('BERKSHIRE HATHAWAY', $response->last()->name);
        $this->assertEquals('0001067983', $response->last()->cik);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Cik::shouldReceive('setCik')
            ->once()
            ->andReturnSelf();

        Cik::setCik('0001067983');
    }
}


