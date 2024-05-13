<?php

namespace App\Http\Requests\Theme\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $current_password
 * @property string $password
 * @property string $confirm_password
 */
final class ThemeAccountChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'regex:/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/'],
            'confirm_password' => ['required', 'string', 'min:8', 'same:password', 'regex:/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/'],
        ];

    }

    public function messages()
    {
        return [
            'password.regex' => 'Ошибка: Пароль не содержит необходимых символов',
            'confirm_password.regex' => 'Ошибка: Пароль не содержит необходимых символов',
            'confirm_password.same' => 'Ошибка: Новый пароль не совпадает',
        ];
    }
}
