<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API key for contacting the financialmodelingprep.com API
    |--------------------------------------------------------------------------
    |
    | Required if you with to use the Financial Modeling Prep API. You can
    | obtain a free API key at their website.
    |
    */

    'api_key' => env('FMP_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Base url
    |--------------------------------------------------------------------------
    |
    | The base url where the call should be made to.
    |
    */

    'base_url' => env('FMP_BASE_URL', 'https://financialmodelingprep.com/api/'),

];
