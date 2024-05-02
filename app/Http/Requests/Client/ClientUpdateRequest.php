<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $status
 * @property string $address
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 * @property string $type_id
 */
class ClientUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'role' => ['required', 'string'],
            'status' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'organization_name' => ['nullable', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
            'type_id' => ['required', 'integer'],
        ];
    }
}
