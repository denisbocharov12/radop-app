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
            'status' => ['required', 'boolean'],
            'order' => ['nullable', 'integer'],
        ];
    }
}
