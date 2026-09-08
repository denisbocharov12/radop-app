<?php

declare(strict_types=1);

namespace App\Repositories\Setting;

use App\Models\DeliverySetting;

class DeliverySettingRepository
{
    private const DEFAULTS = [
        'supplement_free_enabled' => true,
        'supplement_free_start'   => '08:00:00',
        'supplement_free_end'     => '15:00:00',
    ];

    /**
     * Per-request cache of the singleton settings row. Kept static so the
     * value is shared no matter how the repository is resolved.
     */
    private static ?DeliverySetting $cached = null;

    /**
     * The singleton delivery settings row (falls back to sane defaults).
     */
    public function getSettings(): DeliverySetting
    {
        return self::$cached ??= (DeliverySetting::query()->first() ?? new DeliverySetting(self::DEFAULTS));
    }

    /**
     * Persist the given attributes onto the singleton settings row.
     *
     * @param array<string, mixed> $attributes
     */
    public function save(array $attributes): DeliverySetting
    {
        $settings = DeliverySetting::query()->first() ?? new DeliverySetting();
        $settings->fill($attributes)->save();

        self::$cached = $settings;

        return $settings;
    }
}
