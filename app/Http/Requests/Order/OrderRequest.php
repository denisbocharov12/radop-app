<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $order_number
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $user_type
 * @property string $city
 * @property string $note
 * @property int $user_id
 * @property int $manager_id
 * @property string $payment_method
 * @property string $payment_status
 * @property string $status
 * @property string $subtotal
 * @property string $discount
 * @property string $total
 * @property string $delivery_charge
 */
class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_number' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'user_type' => ['required', 'string'],
            'city' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'user_id' => ['nullable', 'integer'],
            'manager_id' => ['nullable', 'integer'],
            'payment_method' => ['required', 'string'],
            'payment_status' => ['required', 'string'],
            'status' => ['required', 'string'],
            'subtotal' => ['nullable', 'string'],
            'discount' => ['nullable', 'string'],
            'total' => ['nullable', 'string'],
            'delivery_charge' => ['nullable', 'string'],
        ];
    }
}
