<?php

namespace App\Http\Requests\Theme\Checkout;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $note
 * @property string $payment_method
 * @property string $delivery_charge
 * @property string $company_name
 * @property string $reserve_phone
 * @property string $bank
 * @property string $idno
 * @property string $tva
 * @property string $registered_city
 * @property string $iur_address
 * @property string $shipping_address
 */
final class ThemeOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'payment_method' => ['required', 'string'],
            'delivery_charge' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
            'reserve_phone' => ['nullable', 'string'],
            'bank' => ['nullable', 'string'],
            'idno' => ['nullable', 'string'],
            'tva' => ['nullable', 'string'],
            'registered_city' => ['nullable', 'string'],
            'iur_address' => ['nullable', 'string'],
            'shipping_address' => ['nullable', 'string']
        ];
    }
}
