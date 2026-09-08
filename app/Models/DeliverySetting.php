<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Site-wide delivery settings (singleton row).
 *
 * @property bool   $supplement_free_enabled
 * @property string $supplement_free_start  "HH:MM:SS"
 * @property string $supplement_free_end    "HH:MM:SS"
 */
class DeliverySetting extends Model
{
    protected $fillable = [
        'supplement_free_enabled',
        'supplement_free_start',
        'supplement_free_end',
    ];

    protected $casts = [
        'supplement_free_enabled' => 'boolean',
    ];

    /**
     * True when the current time of day falls within the free-supplement
     * window [start, end) and the feature is enabled.
     */
    public function isWindowOpenNow(): bool
    {
        if (!$this->supplement_free_enabled) {
            return false;
        }

        $now   = now();
        $start = Carbon::parse($this->supplement_free_start, $now->timezone)->setDateFrom($now);
        $end   = Carbon::parse($this->supplement_free_end, $now->timezone)->setDateFrom($now);

        return $now->greaterThanOrEqualTo($start) && $now->lessThan($end);
    }

    /**
     * A new order qualifies as a free supplement (дозаказ) when the feature is
     * enabled, there is an order placed earlier today to attach to, and the
     * current time is still within the free window.
     */
    public function isSupplementEligible(?Carbon $lastOrderCreatedAt): bool
    {
        if ($lastOrderCreatedAt === null || !$lastOrderCreatedAt->isToday()) {
            return false;
        }

        return $this->isWindowOpenNow();
    }

    public function startLabel(): string
    {
        return Carbon::parse($this->supplement_free_start)->format('H:i');
    }

    public function endLabel(): string
    {
        return Carbon::parse($this->supplement_free_end)->format('H:i');
    }
}
