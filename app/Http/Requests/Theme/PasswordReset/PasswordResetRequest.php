<?php

declare(strict_types=1);

namespace App\Http\Requests\Theme\PasswordReset;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 * @property string $token
 * @property string $password
 */
final class PasswordResetRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'max:99'],
        ];
    }
}
