<?php

namespace Leijman\FmpApiSdk\Tests\InstitutionalFunds;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Facades\InstitutionalFunds\SecRssFeed;
use Leijman\FmpApiSdk\Tests\BaseTestCase;
use TypeError;

class SecRssFeedTest extends BaseTestCase
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
            "title" : "10-K - HUTTIG BUILDING PRODUCTS INC (0001093082) (Filer)",
            "date" : "2021-03-02 17:28:11",
            "link" : "https://www.sec.gov/Archives/edgar/data/1093082/000156459021010338/0001564590-21-010338-index.htm",
            "cik" : "0001093082",
            "form_type" : "10-K",
            "ticker" : "HBP"
          }, {
            "title" : "20-F - Orphazyme A/S (0001764791) (Filer)",
            "date" : "2021-03-02 17:25:05",
            "link" : "https://www.sec.gov/Archives/edgar/data/1764791/000156459021010332/0001564590-21-010332-index.htm",
            "cik" : "0001764791",
            "form_type" : "20-F",
            "ticker" : "ORPH"
          }, {
            "title" : "10-K - MONROE CAPITAL Corp (0001512931) (Filer)",
            "date" : "2021-03-02 17:23:21",
            "link" : "https://www.sec.gov/Archives/edgar/data/1512931/000110465921030862/0001104659-21-030862-index.htm",
            "cik" : "0001512931",
            "form_type" : "10-K",
            "ticker" : "MRCCL"
          }, {
            "title" : "10-K - CARRIAGE SERVICES INC (0001016281) (Filer)",
            "date" : "2021-03-02 17:18:20",
            "link" : "https://www.sec.gov/Archives/edgar/data/1016281/000101628121000071/0001016281-21-000071-index.htm",
            "cik" : "0001016281",
            "form_type" : "10-K",
            "ticker" : "CSV"
        }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_sec_rss_feed_endpoint()
    {
        $sec_rss_feed = new \Leijman\FmpApiSdk\InstitutionalFunds\SecRssFeed($this->client);

        $response = $sec_rss_feed->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('10-K - CARRIAGE SERVICES INC (0001016281) (Filer)', $response->last()->title);
        $this->assertEquals('0001016281', $response->last()->cik);
    }

    /** @test */
    public function it_can_set_a_limit()
    {
        $sec_rss_feed = new \Leijman\FmpApiSdk\InstitutionalFunds\SecRssFeed($this->client);

        $response = $sec_rss_feed->setLimit(4)
            ->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('10-K - CARRIAGE SERVICES INC (0001016281) (Filer)', $response->last()->title);
        $this->assertEquals('0001016281', $response->last()->cik);
    }

    /** @test */
    public function it_should_fail_when_the_limit_is_not_an_integer()
    {
        $sec_rss_feed = new \Leijman\FmpApiSdk\InstitutionalFunds\SecRssFeed($this->client);

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('must be of type int, string given');

        $sec_rss_feed->setLimit('abc')
            ->get();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SecRssFeed::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = SecRssFeed::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
    }
}
