<?php

namespace App\Http\Requests\Theme\Filial;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $address
 * @property string $phone
 * @property int $city_id
 */
class ThemeFilialRequest extends FormRequest
{
    public function rules()
    {
        return [
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'city_id' => ['required', 'integer'],
        ];
    }

    public function validationFailed() {
        return redirect()->back()->withErrors($this->validator)->withInput();
    }
}
