<?php

namespace App\Http\Requests\OneC;

use Illuminate\Foundation\Http\FormRequest;

class OneCRequest extends FormRequest
{
    public function rules()
    {
        return [
            'attachment' => ['required', 'max:10000', 'file', 'mimes:json'],
        ];
    }
}
