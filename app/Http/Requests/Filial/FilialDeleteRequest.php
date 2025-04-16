<?php

namespace App\Http\Requests\Filial;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $filial_id
 */
class FilialDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'filial_id' => ['integer', 'required']
        ];
    }
}
