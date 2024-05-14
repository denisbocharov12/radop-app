<?php
namespace App\Http\Requests\Theme\Search;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $search
 */
final class ThemeSearchRequest extends FormRequest
{
    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'search' => ['required', 'string'],
        ];
    }
}
