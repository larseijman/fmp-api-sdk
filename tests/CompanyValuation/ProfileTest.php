<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\Profile;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class ProfileTest extends BaseTestCase
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
            "symbol" : "AAPL",
            "price" : 125.35,
            "beta" : 1.33758,
            "volAvg" : 104404860,
            "mktCap" : 2104388350000,
            "lastDiv" : 0.82,
            "range" : "53.1525-145.09",
            "changes" : -0.51,
            "companyName" : "Apple Inc",
            "currency" : "USD",
            "cik" : "0000320193",
            "isin" : "US0378331005",
            "cusip" : "037833100",
            "exchange" : "Nasdaq Global Select",
            "exchangeShortName" : "NASDAQ",
            "industry" : "Consumer Electronics",
            "website" : "https://www.apple.com/",
            "description" : "Apple Inc. designs, manufactures, and markets smartphones, personal computers, tablets, wearables, and accessories worldwide. It also sells various related services. The company offers iPhone, a line of smartphones; Mac, a line of personal computers; iPad, a line of multi-purpose tablets; and wearables, home, and accessories comprising AirPods, Apple TV, Apple Watch, Beats products, HomePod, iPod touch, and other Apple-branded and third-party accessories. It also provides AppleCare support services; cloud services store services; and operates various platforms, including the App Store, that allow customers to discover and download applications and digital content, such as books, music, video, games, and podcasts. In addition, the company offers various services, such as Apple Arcade, a game subscription service; Apple Music, which offers users a curated listening experience with on-demand radio stations; Apple News+, a subscription news and magazine service; Apple TV+, which offers exclusive original content; Apple Card, a co-branded credit card; and Apple Pay, a cashless payment service, as well as licenses its intellectual property. The company serves consumers, and small and mid-sized businesses; and the education, enterprise, and government markets. It sells and delivers third-party applications for its products through the App Store. The company also sells its products through its retail and online stores, and direct sales force; and third-party cellular network carriers, wholesalers, retailers, and resellers. Apple Inc. was founded in 1977 and is headquartered in Cupertino, California.",
            "ceo" : "Mr. Timothy Cook",
            "sector" : "Technology",
            "country" : "US",
            "fullTimeEmployees" : "147000",
            "phone" : "14089961010",
            "address" : "1 Apple Park Way",
            "city" : "Cupertino",
            "state" : "CALIFORNIA",
            "zip" : "95014",
            "dcfDiff" : 89.92,
            "dcf" : 127.377,
            "image" : "https://financialmodelingprep.com/image-stock/AAPL.png",
            "ipoDate" : "1980-12-12",
            "defaultImage" : false,
            "isEtf" : false,
            "isActivelyTrading" : true
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $profile = new \Leijman\FmpApiSdk\CompanyValuation\Profile($this->client);

        $this->expectException(InvalidData::class);

        $profile->get();
    }

    /** @test */
    public function it_can_query_the_profile_endpoint()
    {
        $profile = new \Leijman\FmpApiSdk\CompanyValuation\Profile($this->client);

        $response = $profile->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(34, $response);
        $this->assertEquals('AAPL', $response['symbol']);
        $this->assertEquals(false, $response['isEtf']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Profile::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Profile::setSymbol('AAPL');
    }
}