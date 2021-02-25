<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\CompanyValuation\CountriesList;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class CountriesListTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[ "US", "MX", "BR", "GB", "CN", "FI", "NL", "SG", "IN", "CA", "ZA", "BM", "DE", "IE", "CH", "LU", "IL",
            "HK", "TW", "ES", "FR", "MC", "GR", "KR", "PR", "SE", "AU", "RU", "KY", "CL", "CO", "DK", "BE", "JP", "AR", "UY", "CZ", "VI", "JE", "PA",
            "TH", "ID", "IT", "TR", "PH", "CY", "GG", "MO", "NZ", "NO", "PE", "CR", "BS", "PT", "SN", "CI", "IS", "MA", "CW", "IM", "GA", "ZM", "CK",
            "VG", "AE", "JO", "MT", "AT", "PL", "FO", "LI", "GI", "AZ", "FK", "UA", "MY", "MU", "TC", "NG", "MN", "TG", "GE", "VN", "HU", "KH", "SB",
            "PG", "BB", "BD", "DO", "SK", "AI", "LT", "BG" ]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_countries_list_endpoint()
    {
        $countries_list = new \Leijman\FmpApiSdk\CompanyValuation\CountriesList($this->client);

        $response = $countries_list->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(94, $response);
        $this->assertEquals('US', $response->first());
        $this->assertEquals('BG', $response->last());
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        CountriesList::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = CountriesList::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(94, $response);
    }
}
