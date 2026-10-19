<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Adds https:// to a website typed without a scheme and normalises the checkboxes.
     */
    protected function prepareForValidation(): void
    {
        $website = trim((string) $this->input('website_url'));
        if ($website !== '' && ! Str::startsWith(Str::lower($website), ['http://', 'https://'])) {
            $website = 'https://'.$website;
        }

        $this->merge([
            'website_url' => $website !== '' ? $website : null,
            'partner_category_id' => $this->filled('partner_category_id') ? $this->input('partner_category_id') : null,
            'since_year' => $this->filled('since_year') ? $this->input('since_year') : null,
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'remove_logo' => $this->boolean('remove_logo'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'partner_category_id' => ['nullable', 'integer', Rule::exists('partner_categories', 'id')],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'website_url' => ['nullable', 'url:http,https', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'since_year' => ['nullable', 'integer', 'min:1900', 'max:'.(now()->year + 1)],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'remove_logo' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'partner_category_id' => 'category',
            'website_url' => 'website',
            'since_year' => 'partner since',
        ];
    }
}
