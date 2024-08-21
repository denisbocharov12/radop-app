<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $product_id
 */
class FavoriteRequest extends FormRequest
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
