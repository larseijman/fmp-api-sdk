<?php

namespace Leijman\FmpApiSdk;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Leijman\FmpApiSdk\Contracts\Fmp;

class FmpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fmp.php' => config_path('fmp.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fmp.php', 'fmp');

        $this->app->bind(Fmp::class, function () {
            $config = config('fmp');

            $this->guardAgainstInvalidConfig($config);

            $guzzle = new Client([
                'base_uri' => $config['base_url'],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'query' => ['apikey' => $config['api_key']]
            ]);

            return new \Leijman\FmpApiSdk\Client($guzzle);
        });
    }

    /**
     * @param  array|null  $config
     */
    protected function guardAgainstInvalidConfig(array $config = null)
    {
        if (empty($config['base_url'])) {
            // throw InvalidConfig::baseUrlNotSpecified();
        }

        if (empty($config['secret_key'])) {
            // throw InvalidConfig::apiKeyNotSpecified();
        }

        if (empty($config['public_key'])) {
            // throw InvalidConfig::apiKeyNotSpecified();
        }
    }
}