<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $review_id
 * @property bool $status
 */
final class ReviewUpdateStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'review_id' => ['integer', 'required', 'exists:reviews,id'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'review_id.required' => 'ID отзыва не указан',
            'review_id.exists' => 'Отзыв не найден',
            'status.required' => 'Статус обязателен',
        ];
    }
}

