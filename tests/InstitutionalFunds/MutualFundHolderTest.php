<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\MutualFundHolder;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class MutualFundHolderTest extends BaseTestCase
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
            "holder" : "Verition Fund Management LLC",
            "shares" : 3299900,
            "dateReported" : "2021-02-16",
            "change" : 0,
            "weightPercent" : null
          }, {
            "holder" : "CAPITAL FUND MANAGEMENT S.A.",
            "shares" : 1648900,
            "dateReported" : "2021-02-12",
            "change" : 1631701,
            "weightPercent" : null
          }, {
            "holder" : "FJARDE AP-FONDEN /FOURTH SWEDISH NATIONAL PENSION FUND",
            "shares" : 5109136,
            "dateReported" : "2021-02-12",
            "change" : 5109136,
            "weightPercent" : null
          }, {
            "holder" : "Lumina Fund Management LLC",
            "shares" : 64000,
            "dateReported" : "2021-02-12",
            "change" : 64000,
            "weightPercent" : null
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mutual_fund_holder = new \Leijman\FmpApiSdk\InstitutionalFunds\MutualFundHolder($this->client);

        $this->expectException(InvalidData::class);

        $mutual_fund_holder->get();
    }

    /** @test */
    public function it_can_query_the_mutual_fund_holder_endpoint()
    {
        $mutual_fund_holder = new \Leijman\FmpApiSdk\InstitutionalFunds\MutualFundHolder($this->client);

        $response = $mutual_fund_holder->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('Lumina Fund Management LLC', $response->last()->holder);
        $this->assertEquals(64000, $response->last()->shares);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        MutualFundHolder::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        MutualFundHolder::setSymbol('AAPL');
    }
}
