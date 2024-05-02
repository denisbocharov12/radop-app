<?php

namespace App\Http\Requests\Theme\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $username
 * @property string $password
 */
final class ThemeUserLoginRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'username' => ['string', 'min:2', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
