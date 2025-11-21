<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'sitemap' => [
            'driver' => 'local',
            'root' => storage_path('app/sitemap'),
            'url' => env('APP_URL').'/sitemap',
            'visibility' => 'public',
            'throw' => false,
        ],

        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/media'),
            'url' => env('APP_URL').'/media',
            'visibility' => 'public',
        ],

        'files' => [
            'driver' => 'local',
            'root' => storage_path('app/files'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'banners' => [
            'driver' => 'local',
            'root' => storage_path('app/banners'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'telegram' => [
            'driver' => 'local',
            'root' => storage_path('app/telegram'),
            'url' => env('APP_URL').'/storage/app/telegram',
            'visibility' => 'public',
        ],

        'temp_import' => [
            'driver' => 'local',
            'root' => storage_path('app/temp_import'),
            'visibility' => 'private',
        ],

        'export' => [
            'driver' => 'local',
            'root' => storage_path('app/export'),
            'url' => env('APP_URL').'/export',
            'visibility' => 'public',
        ],

        'manager_exports' => [
            'driver' => 'local',
            'root' => storage_path('app/manager_exports'),
            'url' => env('APP_URL').'/manager_exports',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('media') => storage_path('app/media'),
        public_path('files') => storage_path('app/files'),
        public_path('banners') => storage_path('app/banners'),
        public_path('sitemap') => storage_path('app/sitemap'),
        public_path('export') => storage_path('app/export'),
        public_path('manager_exports') => storage_path('app/manager_exports'),
    ],

];
