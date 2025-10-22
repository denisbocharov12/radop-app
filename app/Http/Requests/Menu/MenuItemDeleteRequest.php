<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'menuId' => ['required', 'exists:menus,id'],
            'itemId' => ['required', 'exists:menu_items,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'menuId' => $this->route('menuId'),
            'itemId' => $this->route('itemId'),
        ]);
    }
}

