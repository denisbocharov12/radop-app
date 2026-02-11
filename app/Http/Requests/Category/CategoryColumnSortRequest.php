<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

final class CategoryColumnSortRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:categories,id'],
            'items.*.column' => ['required', 'integer', 'min:1', 'max:3'],
            'items.*.column_order' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => __('validation.required', ['attribute' => 'items']),
            'items.*.id.required' => __('validation.required', ['attribute' => 'id']),
            'items.*.id.exists' => __('validation.exists', ['attribute' => 'id']),
            'items.*.column.required' => __('validation.required', ['attribute' => 'column']),
            'items.*.column.min' => __('validation.min.numeric', ['attribute' => 'column', 'min' => 1]),
            'items.*.column.max' => __('validation.max.numeric', ['attribute' => 'column', 'max' => 3]),
            'items.*.column_order.required' => __('validation.required', ['attribute' => 'column_order']),
            'items.*.column_order.min' => __('validation.min.numeric', ['attribute' => 'column_order', 'min' => 0]),
        ];
    }
}
