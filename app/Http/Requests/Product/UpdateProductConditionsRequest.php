<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array $product_ids
 * @property string $condition
 */
final class UpdateProductConditionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['integer', 'exists:products,id'],
            'condition' => ['required', 'string'],
        ];
    }
}


