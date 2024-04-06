<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $onec_id
 * @property string $title
 * @property string $description
 * @property bool $status
 * @property array $attachments
 */
class BrandRequest extends FormRequest
{
    public function rules()
    {
        return [
            'onec_id' => ['nullable', 'string'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['required', 'max:10000', 'mimes:png,jpg,jpeg'],
        ];
    }
}
