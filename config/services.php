<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'wish' => [
        'auth_url' => env('WISH_AUTH_URL'),
        'api_url' => env('WISH_API_URL'),
        'client_secret' => env('WISH_CLIENT_SECRET', ''),
        'client_id' => env('WISH_CLIENT_ID', '')
    ],
    'sendcloud' => [
        'panel_url' => env('SENDCLOUD_PANEL_URL', 'https://panel.sendcloud.sc/')
    ]
];
