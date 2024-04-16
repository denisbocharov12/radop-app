<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

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
class CouponRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['nullable', 'integer'],
            'value' => ['required', 'string'],
            'code' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'minimal_total' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'start_date' => ['nullable', 'string'],
            'end_date' => ['nullable', 'string'],
        ];
    }
}
