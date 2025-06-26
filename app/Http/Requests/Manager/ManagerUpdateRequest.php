<?php

declare(strict_types = 1);

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $status
 * @property int $city_id
 */
class ManagerUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user')),],
            'phone' => ['required', 'string', 'max:20'],
            'status' => ['required', 'string'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
        ];
    }
}
