<?php

namespace App\Http\Requests\DiscountPeriod;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $sum_from
 * @property string $sum_to
 * @property int $discount_koef
 */
class DiscountPeriodRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sum_from' => ['required', 'string'],
            'sum_to' => ['required', 'string'],
            'discount_koef' => ['required', 'numeric'],
        ];
    }
}
