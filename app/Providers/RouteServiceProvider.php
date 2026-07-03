<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/admin/orders';
    public const CLIENT_HOME = '/dashboard';

    public function boot(): void
    {
        parent::boot();

        $this->configureRateLimiting();
    }

    public function map(): void
    {
        Route::prefix('api/v1')
            ->as('api.')
            ->middleware('api')
            ->group(static function () {
                foreach (File::allFiles(base_path('routes/api/v1')) as $file) {
                    require $file->getPathname();
                }
            })
        ;

        Route::middleware([
            'user',
            'localeSessionRedirect',
            'localizationRedirect',
            'localize',
            'localeCookieRedirect',
            'localeViewPath'
            ])
            ->prefix(LaravelLocalization::setLocale())
            ->as('user.')
            ->group(static function () {
                foreach (File::allFiles(base_path('routes/user')) as $file) {
                    require $file->getPathname();
                }
            })
        ;

        Route::middleware([
            'user',
            'app.client-status',
            'localeSessionRedirect',
            'localizationRedirect',
            'localize',
            'localeCookieRedirect',
            'localeViewPath'
            ])
            ->prefix(LaravelLocalization::setLocale())
            ->as('theme.user.')
            ->group(static function () {
                foreach (File::allFiles(base_path('routes/user/authorized')) as $file) {
                    require $file->getPathname();
                }
            })
        ;

        Route::prefix('admin')
            ->middleware(['web'])
            ->group(static function () {
                foreach (File::allFiles(base_path('routes/v1')) as $file) {
                    require $file->getPathname();
                }
            })
        ;

        Route::prefix('admin')
            ->middleware(['web','auth:sanctum', 'verified'])
            ->group(static function () {
                foreach (File::allFiles(base_path('routes/v1/authorized')) as $file) {
                    require $file->getPathname();
                }
            })
        ;

        Route::middleware([
            'web',
            'localeSessionRedirect',
            'localizationRedirect',
            'localize',
            'localeCookieRedirect',
            'localeViewPath'
            ])
            ->prefix(LaravelLocalization::setLocale())
            ->as('theme.')
            ->group(static function () {
                foreach (File::allFiles(base_path('routes/frontend/v1')) as $file) {
                    require $file->getPathname();
                }
            })
        ;


        Route::middleware('web')->group(base_path('routes/web.php'));
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
