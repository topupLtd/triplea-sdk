<?php

// To get more about the payment setting check this documents
// https://developers.triple-a.io/docs/triplea-api-doc/42cb1cde9fbae-introduction

return [

    // Triple-A Client ID
    'client_id'         => env('TRIPLEA_CLIENT_ID'),

    // Triple-A Client Secret
    'client_secret'     => env('TRIPLEA_CLIENT_SECRET'),

    // Set environment status
    'sandbox'           => env('TRIPLEA_SANDBOX', false),

    // Set payment type triplea or widget
    'payment_type'      => env('TRIPLEA_PAYMENT_TYPE', 'triplea'),

    // Set Merchant Key
    'merchant_key'      => env('TRIPLEA_MERCHANT_KEY'),
    
    'logger'            => env('TRIPLEA_LOGGER', true),
];