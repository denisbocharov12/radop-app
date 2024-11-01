<?php

namespace App\Http\Requests\DeliveryMethod;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name_ro
 * @property string $name_ru
 * @property int $delivery_price
 * @property int $min_cart_sum
 * @property string $status
 */
class DeliveryMethodRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name_ro' => ['required', 'string', 'min:2', 'max:255'],
            'name_ru' => ['required', 'string', 'min:2', 'max:255'],
            'delivery_price' => ['nullable', 'integer'],
            'min_cart_sum' => ['nullable', 'integer'],
            'status' => ['required', 'string'],
        ];
    }
}
