<?php

namespace App\Http\Requests\DeliveryMethod;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $delivery_method_id
 */
class DeliveryMethodDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'delivery_method_id' => ['integer', 'required']
        ];
    }
}
