<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\InstitutionalHolder;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class InstitutionalHolderTest extends BaseTestCase
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
            "holder" : "LAIRD NORTON TRUST COMPANY, LLC",
            "shares" : 56147,
            "dateReported" : "2021-02-26",
            "change" : 56147
          }, {
            "holder" : "Bridge Advisory, LLC",
            "shares" : 38873,
            "dateReported" : "2021-02-26",
            "change" : 38873
          }, {
            "holder" : "M Holdings Securities, Inc.",
            "shares" : 219369,
            "dateReported" : "2021-02-26",
            "change" : 7105
          }, {
            "holder" : "FOCUS Wealth Advisors, LLC",
            "shares" : 15079,
            "dateReported" : "2021-02-26",
            "change" : 15079
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $institutional_holder = new \Leijman\FmpApiSdk\InstitutionalFunds\InstitutionalHolder($this->client);

        $this->expectException(InvalidData::class);

        $institutional_holder->get();
    }

    /** @test */
    public function it_can_query_the_institutional_holder_endpoint()
    {
        $institutional_holder = new \Leijman\FmpApiSdk\InstitutionalFunds\InstitutionalHolder($this->client);

        $response = $institutional_holder->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('FOCUS Wealth Advisors, LLC', $response->last()->holder);
        $this->assertEquals(15079, $response->last()->change);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        InstitutionalHolder::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        InstitutionalHolder::setSymbol('AAPL');
    }
}
