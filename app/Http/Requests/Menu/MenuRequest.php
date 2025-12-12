<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $code
 * @property string $name_ro
 * @property string $name_ru
 * @property string|null $link_ro
 * @property string|null $link_ru
 * @property string|null $description_ro
 * @property string|null $description_ru
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
                Rule::unique('menus', 'code')->ignore($menuId)
            ],
            'name_ro' => ['required', 'string', 'max:255'],
            'name_ru' => ['required', 'string', 'max:255'],
            'link_ro' => ['nullable', 'string', 'max:255'],
            'link_ru' => ['nullable', 'string', 'max:255'],
            'description_ro' => ['nullable', 'string'],
            'description_ru' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:png,svg', 'max:2048'],
            'clear_image' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => __('validation.required', ['attribute' => 'code']),
            'code.unique' => __('validation.unique', ['attribute' => 'code']),
            'name_ro.required' => __('validation.required', ['attribute' => 'name_ro']),
            'name_ru.required' => __('validation.required', ['attribute' => 'name_ru']),
        ];
    }
}

