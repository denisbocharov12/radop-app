<?php

namespace App\Http\Requests\Theme\WishList;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $product_id
 */
final class WishListRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer'],
        ];
    }
}
