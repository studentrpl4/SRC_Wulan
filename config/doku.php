<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DOKU API Credentials
    |--------------------------------------------------------------------------
    |
    | These values are loaded from the environment. Keep sandbox keys in
    | your local .env for staging and testing, and production keys in
    | the production environment.
    |
    */
    'client_id' => env('DOKU_CLIENT_ID'),
    'secret_key' => env('DOKU_SECRET_KEY'),
    'api_key' => env('DOKU_API_KEY'),
    'is_production' => env('DOKU_IS_PRODUCTION', false),
    // Default VA bank to use when building requests (can be overridden per-order)
    'default_va_bank' => env('DOKU_DEFAULT_VA_BANK', 'BRI'),

    // API endpoints
    'endpoints' => [
        'sandbox' => 'https://api-sandbox.doku.com',
        'production' => 'https://api.doku.com',
        // path for direct checkout - may vary by merchant integration
        'direct_checkout' => '/checkout/v1/payment',
    ],
];
