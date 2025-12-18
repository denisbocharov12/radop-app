<?php

declare(strict_types=1);

namespace App\Http\Requests\HeaderMenu;

use Illuminate\Foundation\Http\FormRequest;

class HeaderMenuItemDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'menuId' => ['required', 'exists:header_menus,id'],
            'itemId' => ['required', 'exists:header_menu_items,id'],
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

