<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\CusipMapper;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class CusipMapperTest extends BaseTestCase
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
            "ticker" : "AAON",
            "cusip" : "000360206",
            "company" : "AAON INC"
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_cusip()
    {
        $cusip = new \Leijman\FmpApiSdk\InstitutionalFunds\CusipMapper($this->client);

        $this->expectException(InvalidData::class);

        $cusip->get();
    }

    /** @test */
    public function it_can_query_the_cusip_mapper_endpoint()
    {
        $cusip = new \Leijman\FmpApiSdk\InstitutionalFunds\CusipMapper($this->client);

        $response = $cusip->setCusip('000360206')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('AAON INC', $response['company']);
        $this->assertEquals('000360206', $response['cusip']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        CusipMapper::shouldReceive('setCusip')
            ->once()
            ->andReturnSelf();

        CusipMapper::setCusip('000360206');
    }
}


