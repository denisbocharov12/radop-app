<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class MenuViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View Composer для автоматической загрузки меню в определенные views
        View::composer('*', function ($view) {
            // Можно добавить автоматическую загрузку меню для всех views
            // Например, для header меню
        });

        \Illuminate\Support\Facades\Blade::directive('renderMenu', function ($expression) {
            return "<?php echo app('App\Services\MenuRenderService')->render({$expression}); ?>";
        });

        \Illuminate\Support\Facades\Blade::directive('renderHeaderMenu', function ($expression) {
            return "<?php echo app('App\Services\HeaderMenuRenderService')->render({$expression}); ?>";
        });
    }
}

