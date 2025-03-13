<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $password
 * @property string $status
 * @property string $address
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 * @property string $type_id
 * @property string $sale
 * @property int $city_id
 */
class ClientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string'],
            'status' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'organization_name' => ['nullable', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
            'type_id' => ['required', 'integer'],
            'sale' => ['nullable', 'string'],
            'city_id' => ['required', 'integer']
        ];
    }
}
