<?php

namespace App\Http\Requests\Admin\Docs;

use App\Models\DocSection;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DocTaskRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Defaults the order.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doc_page_id' => ['required', 'integer', 'exists:doc_pages,id'],
            'anchor' => ['required', 'string', 'max:255', function (string $attribute, mixed $value, Closure $fail): void {
                $exists = DocSection::where('doc_page_id', $this->integer('doc_page_id'))->where('anchor', $value)->exists();

                if (! $exists) {
                    $fail('Pick a section of the chosen page.');
                }
            }],
            'icon' => ['required', 'string', 'max:64', 'regex:/^fa-[a-z0-9-]+$/'],
            'title' => ['required', 'string', 'max:255'],
            'title_si' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'doc_page_id' => 'page',
            'anchor' => 'section',
            'title_si' => 'Sinhala title',
        ];
    }
}
