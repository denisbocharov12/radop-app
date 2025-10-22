<?php

declare(strict_types=1);

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

final class MenuDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:menus,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}

