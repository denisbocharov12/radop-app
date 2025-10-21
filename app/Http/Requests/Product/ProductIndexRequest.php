<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class ProductIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'filter' => ['nullable', 'array'],
            'filter.search' => ['nullable', 'string', 'max:255'],
            'filter.status' => ['nullable', 'string', 'in:0,1'],
            'filter.site_status' => ['nullable', 'string', 'in:0,1'],
            'filter.brand' => ['nullable', 'string'],
        ];
    }
}
