<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $onec_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property bool $status
 */
class BrandRequest extends FormRequest
{
    public function rules()
    {
        return [
            'onec_id' => ['nullable', 'string'],
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string']
        ];
    }
}
