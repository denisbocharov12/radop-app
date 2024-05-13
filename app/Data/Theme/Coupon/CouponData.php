<?php
declare(strict_types=1);

namespace App\Data\Theme\Coupon;

/**
 * @property string $code
 */
final class CouponData
{
    public function __construct(
        public readonly string $code,
    )
    {
    }
}
