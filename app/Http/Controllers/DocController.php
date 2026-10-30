<?php

namespace App\Http\Controllers;

use App\Services\DocLibrary;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DocController extends Controller
{
    /**
     * Words a visitor reads per minute, for the "min read" estimate on each chapter.
     */
    private const WORDS_PER_MINUTE = 180;

    public function __construct(private DocLibrary $library) {}

    // GET /docs — the desktop POS user guide: every chapter, grouped as in the sidebar, plus shortcuts to common tasks (managed in /admin/docs)
    public function index(): View
    {
        return view('frontend.docs.index', [
            'groups' => $this->library->groups(),
            'pageCount' => $this->library->pages()->count(),
            'tasks' => $this->library->tasks(),
        ]);
    }

    // GET /docs/{slug} — one chapter (intro, sections and outro from the database); previous/next follow the sidebar order
    public function show(string $slug): View
    {
        $pages = $this->library->pages();
        $slugs = $pages->keys();
        $i = $slugs->search($slug);
        abort_if($i === false, 404);

        $body = (string) $this->library->body($slug);

        return view('frontend.docs.show', [
            'slug' => $slug,
            'page' => $pages[$slug],
            'body' => $body,
            'readingMinutes' => $this->readingMinutes($body),
            'groups' => $this->library->groups(),
            'prev' => $i > 0 ? $pages[$slugs[$i - 1]] + ['slug' => $slugs[$i - 1]] : null,
            'next' => $i < $slugs->count() - 1 ? $pages[$slugs[$i + 1]] + ['slug' => $slugs[$i + 1]] : null,
        ]);
    }

    // GET /docs/api — API conventions plus every resource group, searchable by endpoint
    public function api(): View
    {
        return view('frontend.docs.api.index', [
            'apiGroups' => $this->apiGroups(),
            'resourceCount' => $this->apiResources()->count(),
        ]);
    }

    // GET /docs/api/{slug} — one API resource (body in frontend/docs/api/resources/{slug}); previous/next follow the sidebar order
    public function apiResource(string $slug): View
    {
        $resources = $this->apiResources();
        $slugs = $resources->keys();
        $i = $slugs->search($slug);
        abort_if($i === false, 404);

        $resource = $resources[$slug];
        $apiGroups = $this->apiGroups();

        return view('frontend.docs.api.show', [
            'slug' => $slug,
            'resource' => $resource,
            'group' => $apiGroups[$resource['group']],
            'apiGroups' => $apiGroups,
            'prev' => $i > 0 ? $resources[$slugs[$i - 1]] + ['slug' => $slugs[$i - 1]] : null,
            'next' => $i < $slugs->count() - 1 ? $resources[$slugs[$i + 1]] + ['slug' => $slugs[$i + 1]] : null,
        ]);
    }

    /**
     * API groups keyed by slug, with their title and description in the website's language.
     *
     * @return array<string, array{title: string, label: string, icon: string, description: string, resources: array<string, array<string, mixed>>}>
     */
    private function apiGroups(): array
    {
        return array_map(fn (array $group) => $this->translated($group), config('api-docs.groups'));
    }

    /**
     * Every API resource keyed by slug, in sidebar order, tagged with its group key.
     *
     * @return Collection<string, array{group: string, title: string, description: string, endpoints: array<string, array{0: string, 1: string, 2: string}>}>
     */
    private function apiResources(): Collection
    {
        return collect(config('api-docs.groups'))
            ->flatMap(fn (array $group, string $key) => collect($group['resources'])->map(fn (array $resource) => $resource + ['group' => $key]));
    }

    /**
     * Swaps each value for its `{key}_{locale}` copy when the website is not in English and that copy is filled.
     *
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    private function translated(array $item): array
    {
        $locale = app()->getLocale();

        if ($locale === config('app.fallback_locale')) {
            return $item;
        }

        foreach ($item as $key => $value) {
            if (filled($item["{$key}_{$locale}"] ?? null)) {
                $item[$key] = $item["{$key}_{$locale}"];
            }
        }

        return $item;
    }

    /**
     * Rough reading time of a rendered chapter, at least one minute.
     */
    private function readingMinutes(string $html): int
    {
        $words = preg_split('/\s+/u', trim(strip_tags($html)), flags: PREG_SPLIT_NO_EMPTY);

        return max(1, (int) round(count($words) / self::WORDS_PER_MINUTE));
    }
}
