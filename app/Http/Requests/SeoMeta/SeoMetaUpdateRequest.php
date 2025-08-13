<?php

namespace App\Http\Requests\SeoMeta;

use Illuminate\Foundation\Http\FormRequest;

class SeoMetaUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page_type' => 'required|string',
            'page_id' => 'nullable|string',
            'locale' => 'required|string',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'og_image' => 'nullable|string',
            'canonical' => 'nullable|string',
            'robots' => 'nullable|string',
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => ['required', 'max:10000', 'mimes:png,jpg,jpeg'],
        ];
    }
}
