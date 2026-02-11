<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $start_date
 * @property string $end_date
 * @property string|null $onec_id
 */
class ProductReportRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'onec_id' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.required' => 'Дата начала периода обязательна',
            'start_date.date' => 'Неверный формат даты начала',
            'start_date.date_format' => 'Дата начала должна быть в формате Y-m-d',
            'end_date.required' => 'Дата окончания периода обязательна',
            'end_date.date' => 'Неверный формат даты окончания',
            'end_date.date_format' => 'Дата окончания должна быть в формате Y-m-d',
            'end_date.after_or_equal' => 'Дата окончания должна быть больше или равна дате начала',
        ];
    }
}
