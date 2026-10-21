<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class IndustryRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalises the slug, turns the capabilities textareas into one item per line
     * and drops highlight rows left completely empty. Each highlight row carries its Sinhala
     * title and text, which are split off into highlights_si at the same index.
     */
    protected function prepareForValidation(): void
    {
        $rows = collect($this->input('highlights', []))
            ->filter(fn ($h) => is_array($h) && trim(($h['title'] ?? '').($h['text'] ?? '').($h['title_si'] ?? '').($h['text_si'] ?? '')) !== '')
            ->map(fn (array $h): array => array_map(fn ($value) => trim((string) $value), $h))
            ->values();

        $this->merge([
            'slug' => $this->filled('slug') ? Str::slug($this->input('slug')) : null,
            'icon' => trim((string) $this->input('icon')) ?: 'fa-briefcase',
            'capabilities' => $this->lines($this->input('capabilities')),
            'capabilities_si' => $this->lines($this->input('capabilities_si')),
            'highlights' => $rows->map(fn (array $h): array => [
                'icon' => ($h['icon'] ?? '') ?: 'fa-check',
                'title' => $h['title'] ?? '',
                'text' => $h['text'] ?? '',
            ])->all(),
            'highlights_si' => $rows->map(fn (array $h): array => [
                'title' => $h['title_si'] ?? '',
                'text' => $h['text_si'] ?? '',
            ])->all(),
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
            'is_active' => $this->boolean('is_active'),
            'remove_scene' => $this->boolean('remove_scene'),
        ]);
    }

    /**
     * One trimmed, non-empty item per line of a textarea (or per element when already an array).
     *
     * @return list<string>
     */
    private function lines(mixed $value): array
    {
        if (is_string($value)) {
            $value = preg_split('/\R/u', $value);
        }

        return collect(is_array($value) ? $value : [])->map(fn ($line) => trim((string) $line))->filter()->values()->all();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $icon = ['regex:/^fa-[a-z0-9-]+$/'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('industries', 'slug')->ignore($this->route('industry'))],
            'menu' => ['nullable', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:64', ...$icon],
            'badge' => ['nullable', 'string', 'max:32'],
            'headline' => ['nullable', 'string', 'max:255'],
            'lead' => ['nullable', 'string', 'max:2000'],
            'highlights' => ['array', 'max:6'],
            'highlights.*.icon' => ['required', 'string', 'max:64', ...$icon],
            'highlights.*.title' => ['required', 'string', 'max:255'],
            'highlights.*.text' => ['nullable', 'string', 'max:500'],
            'capabilities' => ['array', 'max:20'],
            'capabilities.*' => ['string', 'max:255'],
            'title_si' => ['nullable', 'string', 'max:255'],
            'menu_si' => ['nullable', 'string', 'max:255'],
            'badge_si' => ['nullable', 'string', 'max:32'],
            'headline_si' => ['nullable', 'string', 'max:255'],
            'lead_si' => ['nullable', 'string', 'max:2000'],
            'highlights_si' => ['array', 'max:6'],
            'highlights_si.*.title' => ['nullable', 'string', 'max:255'],
            'highlights_si.*.text' => ['nullable', 'string', 'max:500'],
            'capabilities_si' => ['array', 'max:20'],
            'capabilities_si.*' => ['string', 'max:255'],
            'meta_title_si' => ['nullable', 'string', 'max:255'],
            'meta_description_si' => ['nullable', 'string', 'max:500'],
            'meta_keywords_si' => ['nullable', 'string', 'max:500'],
            'modules' => ['nullable', 'array'],
            'modules.*' => ['integer', Rule::exists('features', 'id')],
            'scene' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'remove_scene' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'icon.regex' => 'Use a Font Awesome solid icon name, e.g. fa-utensils.',
            'highlights.*.icon.regex' => 'Use a Font Awesome solid icon name, e.g. fa-check.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'scene' => 'scene image',
            'modules.*' => 'module',
            'highlights.*.title' => 'highlight title',
            'highlights.*.icon' => 'highlight icon',
            'highlights.*.text' => 'highlight text',
            'capabilities.*' => 'capability',
            'title_si' => 'Sinhala title',
            'menu_si' => 'Sinhala menu tagline',
            'badge_si' => 'Sinhala badge',
            'headline_si' => 'Sinhala headline',
            'lead_si' => 'Sinhala intro',
            'highlights_si.*.title' => 'Sinhala highlight title',
            'highlights_si.*.text' => 'Sinhala highlight text',
            'capabilities_si.*' => 'Sinhala capability',
            'meta_title_si' => 'Sinhala meta title',
            'meta_description_si' => 'Sinhala meta description',
            'meta_keywords_si' => 'Sinhala meta keywords',
        ];
    }
}
