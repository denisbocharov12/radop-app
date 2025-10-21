<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $user_id
 * @property string $product_onec_id
 * @property string $text
 * @property float $score
 * @property bool $status
 * @property bool $is_verified
 */
final class AdminReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'product_onec_id' => ['required', 'string'],
            'text' => ['required', 'string', 'min:10', 'max:2000'],
            'score' => ['required', 'numeric', 'min:0', 'max:5'],
            'status' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Пользователь не указан',
            'user_id.exists' => 'Пользователь не найден',
            'product_onec_id.required' => 'Товар не указан',
            'text.required' => 'Текст отзыва обязателен',
            'text.min' => 'Минимальная длина отзыва 10 символов',
            'text.max' => 'Максимальная длина отзыва 2000 символов',
            'score.required' => 'Оценка обязательна',
            'score.min' => 'Минимальная оценка 0',
            'score.max' => 'Максимальная оценка 5',
        ];
    }
}

