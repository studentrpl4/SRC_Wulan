<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Provider
    |--------------------------------------------------------------------------
    |
    | Set the default payment provider for the application. Supported values:
    | - midtrans
    | - doku
    |
    */
    'provider' => env('PAYMENT_PROVIDER', 'midtrans'),

];
