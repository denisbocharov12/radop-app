<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $onec_id
 * @property int $parent_id
 * @property string $name
 * @property string $summary
 * @property bool $status
 * @property int $order
 * @property array $attachments
 */
class CategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'onec_id' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer'],
            'name' => ['required', 'string'],
            'summary' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'order' => ['nullable', 'integer'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['required', 'max:10000', 'mimes:png,jpg,jpeg'],
        ];
    }
}
