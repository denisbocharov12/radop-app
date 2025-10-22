<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\MenuRepository;
use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind MenuRepositoryInterface to MenuRepository
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

