<?php

namespace App\Http\Requests\Filial;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $address
 * @property string $phone
 * @property int $city_id
 * @property int $user_id
 */
class FilialRequest extends FormRequest
{
    public function rules()
    {
        return [
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'city_id' => ['required', 'integer'],
            'user_id' => ['nullable', 'integer'],
        ];
    }
}
