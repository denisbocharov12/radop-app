<?php

return [
    'version' => env('FILTER_AJAX_VERSION', 'v2'),

    'versions' => [
        'v1' => [
            'namespace' => 'shop-filter-ajax',
            'components_path' => 'frontend.v1.components',
            'pages_path' => 'frontend.v1.pages',
        ],
        'v2' => [
            'namespace' => 'shop-filter-ajax-v2',
            'components_path' => 'frontend.v1.components',
            'pages_path' => 'frontend.v1.pages',
        ],
    ],
];

