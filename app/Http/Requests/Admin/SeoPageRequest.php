<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SeoPageRequest extends FormRequest
{
    /**
     * Route middleware already checks the edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalises the remove-image checkbox.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image_alt' => ['nullable', 'string', 'max:255'],
            'meta_title_si' => ['nullable', 'string', 'max:255'],
            'meta_description_si' => ['nullable', 'string', 'max:500'],
            'og_image_alt_si' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120', 'dimensions:min_width=600,min_height=315'],
            'remove_image' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'image' => 'share image',
            'og_image_alt' => 'share image description',
            'meta_title_si' => 'Sinhala meta title',
            'meta_description_si' => 'Sinhala meta description',
            'og_image_alt_si' => 'Sinhala share image description',
        ];
    }
}
