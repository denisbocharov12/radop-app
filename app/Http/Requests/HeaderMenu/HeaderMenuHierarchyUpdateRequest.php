<?php

declare(strict_types=1);

namespace App\Http\Requests\HeaderMenu;

use Illuminate\Foundation\Http\FormRequest;

final class HeaderMenuHierarchyUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'structure' => ['required', 'array'],
            'structure.*.id' => ['required', 'exists:header_menu_items,id'],
            'structure.*.parent_id' => ['nullable', 'exists:header_menu_items,id'],
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

