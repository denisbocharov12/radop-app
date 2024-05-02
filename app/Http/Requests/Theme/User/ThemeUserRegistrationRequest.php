<?php

namespace App\Http\Requests\Theme\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $address
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
            'first_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+$/u'],
            'last_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+$/u'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'address' => ['required', 'string'],
            'type_id' => ['required', 'integer'],
            'organization_name' => ['nullable', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Поле обязательно для заполнения',
            'password.min:6' => 'Пароль должен содержать не менее 6 знаков',
            'rule.required' => 'Поле обязательно к согласию',
            'rule_iur.required' => 'Поле обязательно к согласию'
        ];
    }
}
