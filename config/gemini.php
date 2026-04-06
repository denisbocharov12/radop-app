<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Gemini API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Gemini API Key and organization. This will be
    | used to authenticate with the Gemini API - you can find your API key
    | on Google AI Studio, at https://aistudio.google.com/app/apikey.
    */

    'api_key' => env('GEMINI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Gemini Base URL
    |--------------------------------------------------------------------------
    |
    | If you need a specific base URL for the Gemini API, you can provide it here.
    | Otherwise, leave empty to use the default value.
    */
    'base_url' => env('GEMINI_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('GEMINI_REQUEST_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Gemini Model
    |--------------------------------------------------------------------------
    | Model used for SEO generation. gemini-1.5-flash has a free tier.
    | Options: gemini-1.5-flash, gemini-1.5-pro, gemini-2.0-flash-exp
    */
    'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),

    /*
    |--------------------------------------------------------------------------
    | SSL Verification
    |--------------------------------------------------------------------------
    | Set to false if cURL cannot verify Google's SSL certificate
    | (common on Windows dev environments — never disable in production).
    */
    'ssl_verify' => env('GEMINI_SSL_VERIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Rate Limit Backoff (seconds)
    |--------------------------------------------------------------------------
    | How long to wait before retrying a job when Gemini returns 429/quota.
    | Default: 6 hours.
    */
    'rate_limit_backoff' => env('GEMINI_RATE_LIMIT_BACKOFF', 6 * 3600),

    /*
    |--------------------------------------------------------------------------
    | Rate Limits (free tier)
    |--------------------------------------------------------------------------
    | rpm_limit — max requests per minute (free tier: 5, use 4 for safety buffer)
    | rpd_limit — max requests per day   (free tier: 20, use 18 for safety buffer)
    | Bulk dispatch spaces jobs so neither limit is exceeded.
    */
    'rpm_limit' => env('GEMINI_RPM_LIMIT', 4),   // requests per minute (safe)
    'rpd_limit' => env('GEMINI_RPD_LIMIT', 20),  // requests per day (safe)
];
