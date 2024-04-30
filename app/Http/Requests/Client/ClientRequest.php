<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property string $password
 * @property string $status
 * @property string $address
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 */
class ClientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstName' => ['nullable', 'string'],
            'lastName' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string'],
            'status' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'organization_name' => ['nullable', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
        ];
    }
}
