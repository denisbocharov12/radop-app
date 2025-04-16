<?php

namespace App\Http\Requests\Theme\Filial;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $address
 * @property string $contact_name
 */
class ThemeFilialRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'contact_name' => ['nullable', 'string'],
        ];
    }

    public function validationFailed() {
        return redirect()->back()->withErrors($this->validator)->withInput();
    }
}
