<?php

namespace App\Http\Requests\Admin;

use App\Models\Feature;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FeatureRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalises the slug, turns the capabilities textarea into one item per line
     * and drops highlight rows left completely empty.
     */
    protected function prepareForValidation(): void
    {
        $capabilities = $this->input('capabilities');
        if (is_string($capabilities)) {
            $capabilities = preg_split('/\R/', $capabilities);
        }

        $highlights = collect($this->input('highlights', []))
            ->filter(fn ($h) => is_array($h) && trim(($h['title'] ?? '').($h['text'] ?? '')) !== '')
            ->map(fn (array $h): array => [
                'icon' => trim((string) ($h['icon'] ?? '')) ?: 'fa-check',
                'title' => trim((string) ($h['title'] ?? '')),
                'text' => trim((string) ($h['text'] ?? '')),
            ])
            ->values()
            ->all();

        $this->merge([
            'slug' => $this->filled('slug') ? Str::slug($this->input('slug')) : null,
            'icon' => trim((string) $this->input('icon')) ?: 'fa-puzzle-piece',
            'capabilities' => collect($capabilities ?? [])->map(fn ($c) => trim((string) $c))->filter()->values()->all(),
            'highlights' => $highlights,
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
            'is_active' => $this->boolean('is_active'),
            'remove_spot' => $this->boolean('remove_spot'),
            'remove_scene' => $this->boolean('remove_scene'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $image = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'];
        $icon = ['regex:/^fa-[a-z0-9-]+$/'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('features', 'slug')->ignore($this->route('feature'))],
            'menu' => ['nullable', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:64', ...$icon],
            'group' => ['required', Rule::in(array_keys(Feature::GROUPS))],
            'badge' => ['nullable', 'string', 'max:32'],
            'headline' => ['nullable', 'string', 'max:255'],
            'lead' => ['nullable', 'string', 'max:2000'],
            'highlights' => ['array', 'max:6'],
            'highlights.*.icon' => ['required', 'string', 'max:64', ...$icon],
            'highlights.*.title' => ['required', 'string', 'max:255'],
            'highlights.*.text' => ['nullable', 'string', 'max:500'],
            'capabilities' => ['array', 'max:20'],
            'capabilities.*' => ['string', 'max:255'],
            'related' => ['nullable', 'array'],
            'related.*' => ['integer', Rule::exists('features', 'id'), Rule::notIn([$this->route('feature')?->id])],
            'spot' => $image,
            'remove_spot' => ['boolean'],
            'scene' => $image,
            'remove_scene' => ['boolean'],
            'screenshots' => ['nullable', 'array', 'max:12'],
            'screenshots.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'screenshot_captions' => ['nullable', 'array'],
            'screenshot_captions.*' => ['nullable', 'string', 'max:255'],
            'screenshot_order' => ['nullable', 'array'],
            'screenshot_order.*' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'remove_screenshots' => ['nullable', 'array'],
            'remove_screenshots.*' => ['integer'],
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
            'icon.regex' => 'Use a Font Awesome solid icon name, e.g. fa-cash-register.',
            'highlights.*.icon.regex' => 'Use a Font Awesome solid icon name, e.g. fa-check.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'spot' => 'preview image',
            'scene' => 'scene image',
            'screenshots.*' => 'screenshot',
            'related.*' => 'related module',
            'highlights.*.title' => 'highlight title',
            'highlights.*.icon' => 'highlight icon',
            'highlights.*.text' => 'highlight text',
            'capabilities.*' => 'capability',
        ];
    }
}
