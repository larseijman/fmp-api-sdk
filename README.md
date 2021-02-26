# Financial Modeling Prep API SDK
[![Version](https://poser.pugx.org/leijman/fmp-api-sdk/version)](//packagist.org/packages/leijman/fmp-api-sdk)
[![CI](https://github.com/larseijman/fmp-api-sdk/actions/workflows/php.yml/badge.svg)](https://github.com/larseijman/fmp-api-sdk/actions/workflows/php.yml)
[![Total Downloads](https://poser.pugx.org/leijman/fmp-api-sdk/downloads)](//packagist.org/packages/leijman/fmp-api-sdk)
[![License](https://poser.pugx.org/leijman/fmp-api-sdk/license)](//packagist.org/packages/leijman/fmp-api-sdk)

(unofficial) Financial Modeling Prep API SDK for PHP with Laravel 8 support.  
This project is in WIP state and may be unstable. Various endpoints will be added in the future and feel free to contribute to this package. Unfortunately I can't guarantee any warranty or liability for this SDK. For any questions feel free to contact me!

## Requirements
- PHP ^7.3 or ^8.0
- A valid (free) API key from [FMP](https://financialmodelingprep.com/developer)

## Installation
This SDK is published on Packagist and can be obtained via composer.

```bash
composer require leijman/fmp-api-sdk
```

<br/>

## Usage
The SDK uses Guzzle as dependency for interacting with the HTTP layer.
```php
$guzzle = new Client([
    'base_uri' => $baseUrl,
    'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ],
    'query' => ['apikey' => $apiKey]
]);
```
You can now use the Guzzle client as a dependency.
```php
$client = new \Leijman\FmpApiSdk\Client($guzzle);
```
To communicate to the various endpoint you can use the client like so:
```php
use \Leijman\FmpApiSdk\CompanyValuation\Quote;

$endpoint = new Quote($client);
$response = $endpoint->setSymbol('AAPL')->get();

print_r($response);
```

<br/>

### Laravel usage
As of now we only support Laravel 8. If there is any demand for previous versions we might look into adding these.  
The package can be published into your Laravel project by the following command:

```php
php artisan vendor:publish --provider="Leijman\FmpApiSdk\FmpServiceProvider"
```
The configuration file is accessible in `config/fmp.php`.  
Finally update your `.env` file with the given API key.

<br/>

When everything is set you can access the FMP API by the following structure:
```php
use Leijman\FmpApiSdk\Facades\CompanyValuation\StockScreener;

StockScreener::setIsActivelyTrading(true)
    ->setExchange('NYSE,NASDAQ,EURONEXT')
    ->get();
```
