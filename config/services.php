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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'exotel' => [
        'account_sid' => env('EXOTEL_ACCOUNT_SID'),
        'api_key' => env('EXOTEL_API_KEY'),
        'api_token' => env('EXOTEL_API_TOKEN'),
        'caller_id' => env('EXOTEL_CALLER_ID'),
        // Required for leg-level Status + Legs[] in callbacks (see Exotel StatusCallback docs).
        'status_callback_events' => env('EXOTEL_STATUS_CALLBACK_EVENTS', 'terminal'),
        'status_callback_content_type' => env('EXOTEL_STATUS_CALLBACK_CONTENT_TYPE', 'application/json'),
    ],

];
