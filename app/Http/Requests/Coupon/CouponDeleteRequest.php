<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $coupon_id
 */
class CouponDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'coupon_id' => ['integer', 'required']
        ];
    }
}
