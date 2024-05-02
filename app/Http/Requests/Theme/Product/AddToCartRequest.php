<?php

namespace App\Http\Requests\Theme\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $product_qty
 * @property int $product_id
 */
final class AddToCartRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'product_qty' => ['required', 'string'],
            'product_id' => ['required', 'integer'],
        ];
    }
}
