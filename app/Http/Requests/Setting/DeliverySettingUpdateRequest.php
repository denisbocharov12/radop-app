<?php

declare(strict_types=1);

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $supplement_free_start
 * @property string $supplement_free_end
 */
class DeliverySettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplement_free_enabled' => 'nullable|boolean',
            'supplement_free_start'   => 'required|date_format:H:i',
            'supplement_free_end'     => 'required|date_format:H:i|after:supplement_free_start',
        ];
    }

    public function messages(): array
    {
        return [
            'supplement_free_end.after' => 'Время окончания должно быть позже времени начала.',
        ];
    }

    /**
     * Normalized attributes ready for persistence.
     *
     * @return array{supplement_free_enabled: bool, supplement_free_start: string, supplement_free_end: string}
     */
    public function toAttributes(): array
    {
        return [
            'supplement_free_enabled' => $this->boolean('supplement_free_enabled'),
            'supplement_free_start'   => (string) $this->input('supplement_free_start'),
            'supplement_free_end'     => (string) $this->input('supplement_free_end'),
        ];
    }
}
