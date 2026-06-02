<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $start_date
 * @property string $end_date
 * @property int|null $user_id
 * @property int|null $city_id
 * @property string|null $status_id
 * @property string|null $user_type_id
 * @property bool $group_by_clients
 */
class OrderReportRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'status_id' => ['nullable', 'string', 'in:pending,processing,shipped,delivered,cancelled'],
            'user_type_id' => ['nullable', 'string', 'in:iur,fiz'],
            'group_by_clients' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array
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
            'user_id.integer' => 'ID пользователя должен быть числом',
            'user_id.exists' => 'Пользователь с указанным ID не найден',
            'city_id.integer' => 'ID города должен быть числом',
            'city_id.exists' => 'Город с указанным ID не найден',
            'status_id.string' => 'Статус должен быть строкой',
            'status_id.in' => 'Недопустимый статус заказа',
            'user_type_id.string' => 'Тип пользователя должен быть строкой',
            'user_type_id.in' => 'Недопустимый тип пользователя',
        ];
    }
} 