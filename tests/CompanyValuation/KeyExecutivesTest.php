<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\KeyExecutives;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class KeyExecutivesTest extends BaseTestCase
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
            "title" : "Chief Executive Officer & Director",
            "name" : "Mr. Timothy D. Cook",
            "pay" : 11560000,
            "currencyPay" : "USD",
            "gender" : "male",
            "yearBorn" : 1961,
            "titleSince" : null
          }, {
            "title" : "Chief Financial Officer & Senior Vice President",
            "name" : "Mr. Luca  Maestri",
            "pay" : 3580000,
            "currencyPay" : "USD",
            "gender" : "male",
            "yearBorn" : 1964,
            "titleSince" : null
          }, {
            "title" : "Chief Operating Officer",
            "name" : "Mr. Jeffrey E. Williams",
            "pay" : 3570000,
            "currencyPay" : "USD",
            "gender" : "male",
            "yearBorn" : 1964,
            "titleSince" : null
          }, {
            "title" : "Senior Vice President, Gen. Counsel & Sec.",
            "name" : "Ms. Katherine L. Adams",
            "pay" : 3600000,
            "currencyPay" : "USD",
            "gender" : "female",
            "yearBorn" : 1964,
            "titleSince" : null
          }, {
            "title" : "Senior Vice President of People & Retail",
            "name" : "Ms. Deirdre  O\'Brien",
            "pay" : 2690000,
            "currencyPay" : "USD",
            "gender" : "female",
            "yearBorn" : 1967,
            "titleSince" : null
          }, {
            "title" : "Senior Director of Corporation Accounting",
            "name" : "Mr. Chris  Kondo",
            "pay" : null,
            "currencyPay" : "USD",
            "gender" : "male",
            "yearBorn" : null,
            "titleSince" : null
          }, {
            "title" : "Chief Technology Officer",
            "name" : "Mr. James  Wilson",
            "pay" : null,
            "currencyPay" : "USD",
            "gender" : "male",
            "yearBorn" : null,
            "titleSince" : null
          }, {
            "title" : "Chief Information Officer",
            "name" : "Ms. Mary  Demby",
            "pay" : null,
            "currencyPay" : "USD",
            "gender" : "female",
            "yearBorn" : null,
            "titleSince" : null
          }, {
            "title" : "Senior Director of Investor Relations & Treasury",
            "name" : "Ms. Nancy  Paxton",
            "pay" : null,
            "currencyPay" : "USD",
            "gender" : "female",
            "yearBorn" : null,
            "titleSince" : null
          }, {
            "title" : "Senior Vice President of Worldwide Marketing",
            "name" : "Mr. Greg  Joswiak",
            "pay" : null,
            "currencyPay" : "USD",
            "gender" : "male",
            "yearBorn" : null,
            "titleSince" : null
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $key_executives = new \Leijman\FmpApiSdk\CompanyValuation\KeyExecutives($this->client);

        $this->expectException(InvalidData::class);

        $key_executives->get();
    }

    /** @test */
    public function it_can_query_the_key_executives_endpoint()
    {
        $key_executives = new \Leijman\FmpApiSdk\CompanyValuation\KeyExecutives($this->client);

        $response = $key_executives->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
        $this->assertEquals('Mr. Greg  Joswiak', $response->last()->name);
        $this->assertEquals('USD', $response->last()->currencyPay);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        KeyExecutives::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        KeyExecutives::setSymbol('AAPL');
    }
}
