<?php

namespace App\Http\Requests\ProductProfile;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $product_id
 * @property string $sku
 * @property string $summary
 * @property string $description
 * @property string $upp_sale
 * @property string $iur_price
 * @property string condition
 */
class ProductProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => ['required', 'string'],
            'sku' => ['nullable', 'string'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'upp_sale' => ['nullable', 'string'],
            'iur_price' => ['nullable', 'string'],
            'condition' => ['required', 'string'],
        ];
    }
}
