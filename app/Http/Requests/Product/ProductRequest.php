<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $onec_id
 * @property string $title_ro
 * @property string $title_ru
 * @property int $stock
 * @property int $unit
 * @property float $price
 * @property float $sale_price
 * @property string $status
 * @property string $site_status
 * @property int $brand_id
 * @property array $category_id
 * @property array $attachments
 * @property string $sku
 * @property string $summary_ru
 * @property string $summary_ro
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
            'title_ro' => ['required', 'string'],
            'title_ru' => ['required', 'string'],
            'stock' => ['nullable', 'integer'],
            'unit' => ['nullable', 'string'],
            'price' => ['numeric', 'required'],
            'sale_price' => ['numeric', 'nullable'],
            'status' => ['required', 'string'],
            'site_status' => ['required', 'string'],
            'brand_id' => ['nullable', 'string'],
            'category_id' => ['nullable', 'array'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['required', 'max:10000', 'mimes:png,jpg,jpeg'],
            'sku' => ['nullable', 'string'],
            'summary_ro' => ['nullable', 'string'],
            'summary_ru' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'upp_sale' => ['nullable', 'array'],
            'iur_price' => ['nullable', 'numeric'],
            'condition' => ['required', 'string'],
        ];
    }
}
