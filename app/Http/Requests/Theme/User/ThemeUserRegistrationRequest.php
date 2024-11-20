<?php

namespace App\Http\Requests\Theme\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email_fiz
 * @property string $email_iur
 * @property string $phone_fiz
 * @property string $phone_iur
 * @property string $password_fiz
 * @property string $password_iur
 * @property string $address_fiz
 * @property string $address_iur
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 * @property string $type_id
 */
final class ThemeUserRegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required_if:type_id,1', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['required_if:type_id,1', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+$/u'],
            'email_fiz' => ['required_if:type_id,1', 'string'],
            'email_iur' => ['required_if:type_id,2', 'string'],
            'phone_fiz' => ['required_if:type_id,1', 'string'],
            'phone_iur' => ['required_if:type_id,2', 'string'],
            'password_fiz' => ['required_if:type_id,1', 'string', 'min:6'],
            'password_iur' => ['required_if:type_id,2', 'string', 'min:6'],
            'address_fiz' => ['required_if:type_id,1', 'string'],
            'address_iur' => ['required_if:type_id,2', 'string'],
            'type_id' => ['required', 'integer'],
            'organization_name' => ['required_if:type_id,2', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
        ];
    }
}
