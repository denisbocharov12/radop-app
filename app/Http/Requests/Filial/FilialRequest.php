<?php

namespace App\Http\Requests\Filial;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $address
 * @property string $contact_name
 * @property int $user_id
 */
class FilialRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'contact_name' => ['nullable', 'string'],
            'user_id' => ['nullable', 'integer'],
        ];
    }
}
