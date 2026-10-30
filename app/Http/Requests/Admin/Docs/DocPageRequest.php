<?php

namespace App\Http\Requests\Admin\Docs;

use App\Models\DocPage;
use App\Models\DocTask;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class DocPageRequest extends FormRequest
{
    /**
     * Route middleware already checks the create / edit permission.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalises the switches and order, builds missing anchors from their heading,
     * and renumbers the sections in the order they were submitted.
     */
    protected function prepareForValidation(): void
    {
        $sections = collect($this->input('sections', []))
            ->filter(fn (mixed $section): bool => is_array($section))
            ->values()
            ->map(fn (array $section): array => [
                ...$section,
                'anchor' => Str::slug((string) (filled($section['anchor'] ?? null) ? $section['anchor'] : ($section['heading'] ?? ''))),
                'is_custom' => filter_var($section['is_custom'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ])
            ->all();

        $this->merge([
            'sections' => $sections,
            'is_active' => $this->boolean('is_active'),
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var DocPage|null $page */
        $page = $this->route('page');

        return [
            'doc_group_id' => ['required', 'integer', 'exists:doc_groups,id'],
            'slug' => $page
                ? ['prohibited']
                : ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::notIn(DocPage::RESERVED_SLUGS), Rule::unique('doc_pages', 'slug')],
            'number' => ['required', 'string', 'max:16'],
            'icon' => ['required', 'string', 'max:64', 'regex:/^fa-[a-z0-9-]+$/'],
            'title' => ['required', 'string', 'max:255'],
            'title_si' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'description_si' => ['nullable', 'string', 'max:500'],
            'intro' => ['nullable', 'string', 'max:200000'],
            'intro_si' => ['nullable', 'string', 'max:200000'],
            'outro' => ['nullable', 'string', 'max:200000'],
            'outro_si' => ['nullable', 'string', 'max:200000'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'is_active' => ['boolean'],
            'sections' => ['required', 'array', 'min:1', 'max:50'],
            'sections.*.anchor' => ['required', 'string', 'max:255', 'distinct'],
            'sections.*.heading' => ['required', 'string', 'max:255'],
            'sections.*.heading_si' => ['nullable', 'string', 'max:255'],
            'sections.*.body' => ['nullable', 'string', 'max:200000'],
            'sections.*.body_si' => ['nullable', 'string', 'max:200000'],
            'sections.*.is_custom' => ['boolean'],
        ];
    }

    /**
     * A custom section must carry its own id="{anchor}"; a section a common task links to cannot be removed.
     *
     * @return list<callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $sections = collect($this->input('sections', []));

                foreach ($sections as $i => $section) {
                    if ($section['is_custom'] && ! str_contains((string) ($section['body'] ?? ''), 'id="'.$section['anchor'].'"')) {
                        $validator->errors()->add("sections.{$i}.body", "A custom section's HTML must contain an element with id=\"{$section['anchor']}\".");
                    }
                }

                /** @var DocPage|null $page */
                $page = $this->route('page');
                $missing = $page
                    ? DocTask::where('doc_page_id', $page->id)->whereNotIn('anchor', $sections->pluck('anchor'))->pluck('title')
                    : collect();

                if ($missing->isNotEmpty()) {
                    $validator->errors()->add('sections', 'These common tasks link to a section you removed or renamed: '.$missing->implode(', ').'. Change those tasks first.');
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'doc_group_id' => 'group',
            'title_si' => 'Sinhala title',
            'description_si' => 'Sinhala description',
            'intro_si' => 'Sinhala intro',
            'outro_si' => 'Sinhala closing content',
            'sections.*.anchor' => 'section anchor',
            'sections.*.heading' => 'section heading',
            'sections.*.heading_si' => 'Sinhala section heading',
            'sections.*.body' => 'section content',
            'sections.*.body_si' => 'Sinhala section content',
        ];
    }
}
