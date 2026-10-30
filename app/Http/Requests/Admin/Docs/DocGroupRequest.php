<?php

namespace App\Http\Requests\Admin\Docs;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DocGroupRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Builds the key from the name when left empty, and defaults the order.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'key' => Str::slug((string) ($this->filled('key') ? $this->input('key') : $this->input('name'))),
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_si' => ['nullable', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:64', 'alpha_dash', Rule::unique('doc_groups', 'key')->ignore($this->route('group'))],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name_si' => 'Sinhala name',
        ];
    }
}
