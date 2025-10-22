<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array $structure
 */
final class MenuHierarchyUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'structure' => ['required', 'array'],
            'structure.*.id' => ['required', 'exists:menu_items,id'],
            'structure.*.parent_id' => ['nullable', 'exists:menu_items,id'],
            'structure.*.order' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'structure.required' => __('validation.required', ['attribute' => 'structure']),
            'structure.array' => __('validation.array', ['attribute' => 'structure']),
        ];
    }
}

