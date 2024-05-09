<?php

namespace App\Http\Requests\Theme\Coupon;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $code
 */
final class ThemeCouponRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => ['required', 'string'],
        ];
    }
}
