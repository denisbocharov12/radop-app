<?php

declare(strict_types=1);

namespace App\Http\Requests\HeaderMenu;

use Illuminate\Foundation\Http\FormRequest;

final class HeaderMenuDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:header_menus,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}

