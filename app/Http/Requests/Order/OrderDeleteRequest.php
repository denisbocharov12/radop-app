<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $order_id
 */
class OrderDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => ['integer', 'required']
        ];
    }
}
