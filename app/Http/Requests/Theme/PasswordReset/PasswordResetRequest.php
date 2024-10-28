<?php

declare(strict_types=1);

namespace App\Http\Requests\PasswordReset;

use App\Http\Requests\BaseRequest;

/**
 * @property string $email
 * @property string $token
 * @property string $password
 */
final class PasswordResetRequest extends BaseRequest
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
