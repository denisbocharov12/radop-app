<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $code
 * @property string $name
 * @property string|null $link
 * @property string|null $description
 * @property bool $is_active
 */
final class MenuRequest extends FormRequest
{
    public function rules(): array
    {
        $menuId = $this->route('id');

        return [
            'code' => [
                'required',
                'string',
                'max:255',
                'unique:menus,code' . ($menuId ? ',' . $menuId : '')
            ],
            'name' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => __('validation.required', ['attribute' => 'code']),
            'code.unique' => __('validation.unique', ['attribute' => 'code']),
            'name.required' => __('validation.required', ['attribute' => 'name']),
        ];
    }
}

