<?php

namespace App\Http\Requests\Media;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $id
 */

class ModelMediaDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => ['integer', 'required']
        ];
    }
}
