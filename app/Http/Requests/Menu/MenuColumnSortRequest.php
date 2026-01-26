<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

final class MenuColumnSortRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['required', 'integer', 'exists:menu_items,id'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:menu_items,id'],
            'items.*.column' => ['required', 'integer', 'min:1', 'max:3'],
            'items.*.column_order' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_id.required' => __('validation.required', ['attribute' => 'parent_id']),
            'parent_id.exists' => __('validation.exists', ['attribute' => 'parent_id']),
            'items.required' => __('validation.required', ['attribute' => 'items']),
            'items.array' => __('validation.array', ['attribute' => 'items']),
            'items.*.id.required' => __('validation.required', ['attribute' => 'item id']),
            'items.*.id.exists' => __('validation.exists', ['attribute' => 'item id']),
            'items.*.column.required' => __('validation.required', ['attribute' => 'column']),
            'items.*.column.min' => __('validation.min.numeric', ['attribute' => 'column', 'min' => 1]),
            'items.*.column.max' => __('validation.max.numeric', ['attribute' => 'column', 'max' => 3]),
            'items.*.column_order.required' => __('validation.required', ['attribute' => 'column_order']),
            'items.*.column_order.min' => __('validation.min.numeric', ['attribute' => 'column_order', 'min' => 0]),
        ];
    }
}
