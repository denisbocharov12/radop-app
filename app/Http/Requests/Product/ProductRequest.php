<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $onec_id
 * @property string $title
 * @property int $stock
 * @property int $unit
 * @property float $price
 * @property float $sale_price
 * @property bool $status
 * @property int $brand_id
 * @property int $category_id
 * @property string $currency
 * @property array $attachments
 * @property string $sku
 * @property string $summary
 * @property string $description
 * @property array $upp_sale
 * @property string $iur_price
 * @property string $condition
 */
class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'onec_id' => ['nullable', 'string'],
            'title' => ['required', 'string'],
            'stock' => ['nullable', 'integer'],
            'unit' => ['nullable', 'string'],
            'price' => ['numeric', 'required'],
            'sale_price' => ['numeric', 'nullable'],
            'status' => ['required', 'string'],
            'brand_id' => ['nullable', 'string'],
            'category_id' => ['nullable', 'array'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['required', 'max:10000', 'mimes:png,jpg,jpeg'],
            'sku' => ['nullable', 'string'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'upp_sale' => ['nullable', 'array'],
            'iur_price' => ['nullable', 'numeric'],
            'condition' => ['required', 'string'],
        ];
    }
}
