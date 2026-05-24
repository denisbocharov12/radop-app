<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Banner;
use App\Repositories\Banner\BannerRepository;

/**
 * Invalidates the front-facing banner cache as soon as an admin saves,
 * deletes, or restores a Banner row. Without this the homepage keeps
 * serving stale banners until the 2-hour TTL expires.
 */
final class BannerObserver
{
    public function saved(Banner $banner): void
    {
        BannerRepository::flushFrontCache();
    }

    public function deleted(Banner $banner): void
    {
        BannerRepository::flushFrontCache();
    }

    public function restored(Banner $banner): void
    {
        BannerRepository::flushFrontCache();
    }
}
