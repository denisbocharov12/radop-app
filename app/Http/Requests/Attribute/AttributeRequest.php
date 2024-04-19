<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $onec_id
 * @property string $name
 * @property string $status
 */
final class AttributeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'onec_id' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
        ];
    }
}
