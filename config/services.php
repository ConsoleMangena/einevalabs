<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'pesepay' => [
        'integration_key' => env('PESEPAY_INTEGRATION_KEY'),
        'encryption_key' => env('PESEPAY_ENCRYPTION_KEY'),
        'sandbox' => env('PESEPAY_SANDBOX', false),
        'currency' => env('PESEPAY_CURRENCY', 'USD'),
        'reason' => env('PESEPAY_REASON', 'EINEVA Labs Store Checkout'),

        /*
         | Seconds to wait for the gateway to connect / respond before we give
         | up. Checkout is a synchronous user-facing request, so a hung
         | gateway must not be able to hold the PHP worker open indefinitely.
         */
        'connect_timeout' => (int) env('PESEPAY_CONNECT_TIMEOUT', 10),
        'timeout' => (int) env('PESEPAY_TIMEOUT', 30),
    ],

    'web3forms' => [
        'access_key' => env('WEB3FORMS_ACCESS_KEY'),
        'endpoint' => env('WEB3FORMS_ENDPOINT', 'https://api.web3forms.com/submit'),
        'timeout' => (int) env('WEB3FORMS_TIMEOUT', 10),
    ],

];
