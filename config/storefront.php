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

    /*
     * Local development with a production database dump: missing /media and
     * /storage files are redirected to this host (e.g. https://radop.md).
     * Only honoured when APP_ENV=local; leave empty everywhere else.
     */
    'media_fallback_url' => env('STOREFRONT_MEDIA_FALLBACK_URL'),

    /*
     * ТЗ 55-57: информационные бейджи на фото товара (BPA FREE, FSC, ECO и т.п.).
     * Ключ — название характеристики так, как оно заведено в номенклатуре;
     * значение — подпись на бейдже. Бейдж появляется, когда у товара эта
     * характеристика заполнена значением «да» / «yes» / «1».
     * Одновременно показываем не больше двух — правый верхний угол фото.
     */
    'photo_badges' => [
        'attributes' => [
            // 'BPA FREE' => 'BPA FREE',
            // 'FSC' => 'FSC',
            // 'ECO' => 'ECO',
        ],
        'limit' => 2,
    ],

];
