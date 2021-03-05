<?php

namespace Leijman\FmpApiSdk\Tests\CompanyValuation;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Leijman\FmpApiSdk\Exceptions\InvalidData;
use Leijman\FmpApiSdk\Facades\CompanyValuation\Rating;
use Leijman\FmpApiSdk\Tests\BaseTestCase;

class RatingTest extends BaseTestCase
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
            "date" : "2021-02-24",
            "rating" : "S",
            "ratingScore" : 5,
            "ratingRecommendation" : "Strong Buy",
            "ratingDetailsDCFScore" : 5,
            "ratingDetailsDCFRecommendation" : "Strong Buy",
            "ratingDetailsROEScore" : 5,
            "ratingDetailsROERecommendation" : "Strong Buy",
            "ratingDetailsROAScore" : 3,
            "ratingDetailsROARecommendation" : "Neutral",
            "ratingDetailsDEScore" : 5,
            "ratingDetailsDERecommendation" : "Strong Buy",
            "ratingDetailsPEScore" : 5,
            "ratingDetailsPERecommendation" : "Strong Buy",
            "ratingDetailsPBScore" : 5,
            "ratingDetailsPBRecommendation" : "Strong Buy"
        }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $rating = new \Leijman\FmpApiSdk\CompanyValuation\Rating($this->client);

        $this->expectException(InvalidData::class);

        $rating->get();
    }

    /** @test */
    public function it_can_query_the_rating_endpoint()
    {
        $rating = new \Leijman\FmpApiSdk\CompanyValuation\Rating($this->client);

        $response = $rating->setSymbol('AAPL')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(17, $response);
        $this->assertEquals('AAPL', $response['symbol']);
        $this->assertEquals(5, $response['ratingScore']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Rating::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Rating::setSymbol('AAPL');
    }
}
