<?php

namespace App\Http\Requests\DiscountPeriod;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $discount_period_id
 */
class DiscountPeriodDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'discount_period_id' => ['integer', 'required']
        ];
    }
}
