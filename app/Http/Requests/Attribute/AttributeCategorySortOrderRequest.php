<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $category_id
 * @property array $order
 */
class AttributeCategorySortOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'string', Rule::exists('categories', 'onec_id')],
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:attributes,id'],
            'order.*.position' => ['required', 'integer', 'min:0'],
        ];
    }
}
