<?php

namespace Leijman\FmpApiSdk\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Leijman\FmpApiSdk\CompanyValuation\StockScreener;
use Leijman\FmpApiSdk\Facades\CompanyValuation\Quote;
use Leijman\FmpApiSdk\FmpServiceProvider;

class BaseTestCase extends \Orchestra\Testbench\TestCase
{
    protected $client;

    /**
     * @var Response|null
     */
    protected $response = null;

    protected function setConfig(): void
    {
        $this->app['config']->set('fmp.base_url', env('FMP_BASE_URL'));
        $this->app['config']->set('fmp.api_key', env('FMP_API_KEY'));
    }

    protected function setupMockedClient(Response $response)
    {
        $mock = new MockHandler([$response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return  new \Leijman\FmpApiSdk\Client($client);
    }

    protected function getPackageProviders($app)
    {
        return [
            FmpServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Quote' => Quote::class,
            'StockScreener' => StockScreener::class,
        ];
    }
}
