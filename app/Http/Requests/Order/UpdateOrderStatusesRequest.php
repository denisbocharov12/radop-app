<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array $order_ids
 * @property string $status
 */
class UpdateOrderStatusesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_ids' => ['required', 'array'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
            'status' => ['required', 'string'],
        ];
    }
}
