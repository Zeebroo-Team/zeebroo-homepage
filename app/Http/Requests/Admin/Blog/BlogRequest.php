<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * A custom slug is normalised here; an empty one is generated from the title by the model.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->filled('slug') ? Str::slug($this->input('slug')) : null,
            'is_active' => $this->boolean('is_active'),
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blogs', 'slug')->ignore($this->route('blog'))],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'category_id' => ['nullable', 'integer', Rule::exists('blog_categories', 'id')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', Rule::exists('blog_tags', 'id')],
            'author_name' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'remove_image' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'tags.*' => 'tag',
        ];
    }
}
