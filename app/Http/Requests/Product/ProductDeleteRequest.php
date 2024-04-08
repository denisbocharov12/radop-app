<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $product_id
 */
class ProductDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => ['integer', 'required']
        ];
    }
}
