# fmp-api-sdk
Financial Modeling Prep API SDK for PHP with Laravel 8 support.

Laravel usage:
```php
use Leijman\FmpApiSdk\Facades\CompanyValuation\StockScreener;

StockScreener::setIsActivelyTrading(true)
    ->setExchange('NYSE,NASDAQ,EURONEXT')
    ->get();
```
