<?php

namespace App\Providers;

use App\Repositories\Product\ProductErrorRepository;
use Gemini;
use Gemini\Client;
use Gemini\Contracts\ClientContract;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Override Gemini HTTP client to support SSL_VERIFY env flag.
        // Set GEMINI_SSL_VERIFY=false in .env when cURL cannot verify
        // the Google API certificate (common on Windows dev environments).
        $this->app->singleton(ClientContract::class, static function (): Client {
            $apiKey  = config('gemini.api_key');
            $timeout = (int) config('gemini.request_timeout', 30);
            $verify  = (bool) config('gemini.ssl_verify', true);

            $guzzle = new GuzzleClient([
                'timeout' => $timeout,
                'verify'  => $verify,
            ]);

            $factory = Gemini::factory()
                ->withApiKey(apiKey: $apiKey)
                ->withHttpClient(client: $guzzle);

            $baseUrl = config('gemini.base_url');
            if (!empty($baseUrl)) {
                $factory->withBaseUrl(baseUrl: $baseUrl);
            }

            return $factory->make();
        });

        $this->app->alias(ClientContract::class, 'gemini');
        $this->app->alias(ClientContract::class, Client::class);
    }

    public function boot(): void
    {
        $this->app['request']->server->set('HTTPS', 'on');

        // Share the product-error summary with the admin sidebar so the
        // "Товары" menu item can show a badge with the number of broken
        // products. Cached in the repository; failures must never break the
        // admin layout (e.g. before the migration has run).
        View::composer('v1.sidebar.sidebar', function ($view): void {
            $summary = ['products' => 0, 'products_critical' => 0, 'products_minor' => 0, 'rows' => 0, 'by_type' => []];
            try {
                $summary = app(ProductErrorRepository::class)->summary();
            } catch (Throwable) {
                // Table may not exist yet / DB unavailable — degrade silently.
            }
            $view->with('sidebarProductErrors', $summary);
        });
    }
}
