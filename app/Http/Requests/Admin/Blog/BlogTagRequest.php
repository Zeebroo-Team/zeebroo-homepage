<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogTagRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * A custom slug is normalised here; an empty one is generated from the name by the model.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->filled('slug') ? Str::slug($this->input('slug')) : null,
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blog_tags', 'slug')->ignore($this->route('tag'))],
            'is_active' => ['boolean'],
        ];
    }
}
