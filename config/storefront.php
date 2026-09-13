<?php

/*
 * Storefront v2 presentation settings.
 */
return [

    /*
     * Brand lockup used by <x-sf-logo> in the header, footer, auth dialog and
     * e-mails-facing pages. To change the logo:
     *
     *  - replace the mark only: point `mark` at a new square-ish SVG;
     *  - use a finished horizontal lockup: set `full` to its path — it then
     *    replaces the mark + wordmark pair entirely;
     *  - hide the typeset wordmark: set `wordmark` to null.
     */
    'logo' => [
        'mark' => '/v1/frontend/assets/images/logo.svg',
        'full' => env('STOREFRONT_LOGO_FULL'),
        'wordmark' => 'RADOP',
        'tagline' => [
            'ro' => 'rechizite de birou și școlare',
            'ru' => 'канцтовары для офиса и школы',
            'en' => 'office & school supplies',
        ],
    ],

];
