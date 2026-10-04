<?php

declare(strict_types=1);

namespace App\Http\Requests\SearchPopularCritery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class SearchPopularCriteryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $id = $this->route('searchPopularCritery')?->id;

        return [
            'query' => [
                'required',
                'string',
                'min:3',
                'max:60',
                // Один и тот же запрос на одном языке не должен задваиваться:
                // иначе счётчики разойдутся по двум строкам.
                Rule::unique('search_popular_criteries', 'query')
                    ->where('locale', $this->input('locale'))
                    ->ignore($id),
            ],
            'locale' => ['required', 'string', Rule::in(array_keys(config('laravellocalization.supportedLocales', [])))],
            'position' => ['required', 'integer', 'min:0', 'max:10000'],
            'is_pinned' => ['required', 'boolean'],
            'is_hidden' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'query' => mb_strtolower(trim(preg_replace('~\s+~u', ' ', (string) $this->input('query')) ?? '')),
            'is_pinned' => (bool) $this->input('is_pinned'),
            'is_hidden' => (bool) $this->input('is_hidden'),
            'position' => (int) $this->input('position', 0),
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'query' => 'запрос',
            'locale' => 'язык',
            'position' => 'порядок',
        ];
    }
}
