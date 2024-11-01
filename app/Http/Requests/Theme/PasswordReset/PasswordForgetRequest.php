<?php

declare(strict_types=1);

namespace App\Http\Requests\Theme\PasswordReset;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $email
 */
final class PasswordForgetRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
