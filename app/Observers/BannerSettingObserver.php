<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\BannerSetting;
use App\Repositories\Banner\BannerRepository;

/**
 * Clears the cached homepage autoplay speed when banner rotation settings
 * are updated in the admin panel.
 */
final class BannerSettingObserver
{
    public function saved(BannerSetting $setting): void
    {
        BannerRepository::flushAutoplayCache();
    }
}
