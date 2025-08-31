<?php

namespace App\Http\Requests\ViewCount;

use Illuminate\Foundation\Http\FormRequest;

final class ViewCountReportRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'product_id' => 'nullable|integer|exists:products,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'category_id' => 'nullable|integer|exists:categories,id',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'start_date.required' => 'Дата начала периода обязательна',
            'start_date.date' => 'Дата начала должна быть в формате даты',
            'start_date.before_or_equal' => 'Дата начала должна быть меньше или равна дате окончания',
            'end_date.required' => 'Дата окончания периода обязательна',
            'end_date.date' => 'Дата окончания должна быть в формате даты',
            'end_date.after_or_equal' => 'Дата окончания должна быть больше или равна дате начала',
            'product_id.integer' => 'ID товара должен быть числом',
            'product_id.exists' => 'Товар с указанным ID не найден',
            'brand_id.integer' => 'ID бренда должен быть числом',
            'brand_id.exists' => 'Бренд с указанным ID не найден',
            'category_id.integer' => 'ID категории должен быть числом',
            'category_id.exists' => 'Категория с указанным ID не найдена',
        ];
    }
} 