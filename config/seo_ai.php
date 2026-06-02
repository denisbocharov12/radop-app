<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default SEO AI Provider
    |--------------------------------------------------------------------------
    |
    | Which AI provider generates SEO metadata when no provider is explicitly
    | chosen in the admin panel. Supported: "gemini", "claude".
    | Per-request selection in the UI overrides this default.
    */

    'provider' => env('SEO_AI_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Provider display labels (for the admin UI)
    |--------------------------------------------------------------------------
    */

    'labels' => [
        'gemini' => 'Google Gemini',
        'claude' => 'Anthropic Claude',
    ],
];
