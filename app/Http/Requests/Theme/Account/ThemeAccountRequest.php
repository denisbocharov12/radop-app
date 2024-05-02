<?php

namespace App\Http\Requests\Theme\Account;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $organization_name
 * @property string $cod_fiscal
 * @property string $contact_name
 */

final class ThemeAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'organization_name' => ['nullable', 'string'],
            'cod_fiscal' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
        ];
    }
}
