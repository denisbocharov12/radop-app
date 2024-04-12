<?php

namespace App\Data\Coupon;

/**
 * @property int $user_id
 * @property string $value
 * @property string $code
 * @property string $type
 * @property string $minimal_total
 * @property bool $status
 * @property string $start_date
 * @property string $end_date
 */
final class CouponData
{
    public ?int $user_id;
    public string $value;
    public string $code;
    public string $type;
    public ?string $minimal_total;
    public string $status;
    public ?string $start_date;
    public ?string $end_date;

    public function __construct(
        ?int    $user_id,
        string  $value,
        string  $code,
        string  $type,
        ?string $minimal_total,
        string  $status,
        ?string $start_date,
        ?string $end_date
    ){
        $this->user_id = $user_id;
        $this->value = $value;
        $this->code = $code;
        $this->type = $type;
        $this->minimal_total = $minimal_total;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
}
