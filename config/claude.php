<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Anthropic Claude API Key
    |--------------------------------------------------------------------------
    |
    | An Anthropic *API* key from https://console.anthropic.com/settings/keys.
    | NOTE: this is billed separately from a Claude.ai chat subscription —
    | a chat subscription does NOT grant API access.
    */

    'api_key' => env('CLAUDE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    */

    'base_url' => env('CLAUDE_BASE_URL', 'https://api.anthropic.com'),

    /*
    |--------------------------------------------------------------------------
    | API Version header (anthropic-version)
    |--------------------------------------------------------------------------
    */

    'version' => env('CLAUDE_API_VERSION', '2023-06-01'),

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    | Model used for SEO generation. Options include:
    | claude-sonnet-4-6 (quality), claude-haiku-4-5 (cheap/fast).
    */

    'model' => env('CLAUDE_MODEL', 'claude-sonnet-4-6'),

    /*
    |--------------------------------------------------------------------------
    | Max output tokens
    |--------------------------------------------------------------------------
    */

    'max_tokens' => env('CLAUDE_MAX_TOKENS', 1024),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout (seconds)
    |--------------------------------------------------------------------------
    */

    'request_timeout' => env('CLAUDE_REQUEST_TIMEOUT', 60),

    /*
    |--------------------------------------------------------------------------
    | SSL Verification
    |--------------------------------------------------------------------------
    | Set to false if cURL cannot verify the SSL certificate
    | (common on Windows dev environments — never disable in production).
    */

    'ssl_verify' => env('CLAUDE_SSL_VERIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Rate Limit Backoff (seconds)
    |--------------------------------------------------------------------------
    | How long to wait before retrying a job when Claude returns 429/overloaded.
    */

    'rate_limit_backoff' => env('CLAUDE_RATE_LIMIT_BACKOFF', 3600),

    /*
    |--------------------------------------------------------------------------
    | Bulk dispatch rate limits
    |--------------------------------------------------------------------------
    | rpm_limit — max requests per minute used to space out bulk jobs.
    | rpd_limit — max requests per day before shifting to the next day-slot.
    | Anthropic tier-1 defaults are generous; tune to your plan.
    */

    'rpm_limit' => env('CLAUDE_RPM_LIMIT', 30),
    'rpd_limit' => env('CLAUDE_RPD_LIMIT', 1000),
];
