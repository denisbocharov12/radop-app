<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\HeaderMenuRepository;
use App\Repositories\HeaderMenuRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class HeaderMenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HeaderMenuRepositoryInterface::class, HeaderMenuRepository::class);
    }

    public function boot(): void
    {
    }
}

