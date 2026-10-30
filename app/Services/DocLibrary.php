<?php

namespace App\Services;

use App\Models\DocGroup;
use App\Models\DocPage;
use App\Models\DocTask;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * The user guide shown at /docs, read from the database (managed in /admin/docs) and cached per
 * language. Pages come back in the shape the docs views expect: keyed by slug, with group, number,
 * icon, title, description and sections (anchor => heading), in sidebar order.
 */
class DocLibrary
{
    private const VERSION_KEY = 'docs.library.version';

    private const TTL_SECONDS = 86400;

    /**
     * Drops every cached copy; called whenever a docs record changes.
     */
    public static function flush(): void
    {
        Cache::forever(self::VERSION_KEY, (string) Str::uuid());
    }

    /**
     * Active pages keyed by slug, in sidebar order.
     *
     * @return Collection<string, array{group: string, number: string, icon: string, title: string, description: string, sections: array<string, string>}>
     */
    public function pages(): Collection
    {
        return collect($this->library()['pages']);
    }

    /**
     * Active pages grouped under their translated sidebar heading.
     *
     * @return Collection<string, Collection<string, array<string, mixed>>>
     */
    public function groups(): Collection
    {
        $labels = $this->library()['groupLabels'];

        return $this->pages()
            ->groupBy('group', preserveKeys: true)
            ->mapWithKeys(fn (Collection $pages, string $group) => [$labels[$group] => $pages]);
    }

    /**
     * "Common tasks" shortcuts whose page is active, with that page's title.
     *
     * @return Collection<int, array{icon: string, page: string, anchor: string, title: string, pageTitle: string}>
     */
    public function tasks(): Collection
    {
        return collect($this->library()['tasks']);
    }

    /**
     * The rendered body of an active page: intro, every section, then outro; null for an unknown slug.
     */
    public function body(string $slug): ?string
    {
        return Cache::remember($this->key("body.{$slug}"), self::TTL_SECONDS, function () use ($slug): ?string {
            $page = DocPage::active()->with('sections')->firstWhere('slug', $slug);

            return $page ? view('frontend.docs.partials.body', ['page' => $page])->render() : null;
        });
    }

    /**
     * @return array{pages: array<string, array<string, mixed>>, groupLabels: array<string, string>, tasks: list<array<string, string>>}
     */
    private function library(): array
    {
        return Cache::remember($this->key('library'), self::TTL_SECONDS, function (): array {
            $pages = DocPage::active()->ordered()->with(['group', 'sections'])->get();
            $titles = $pages->pluck('title', 'slug');

            return [
                'pages' => $pages->mapWithKeys(fn (DocPage $page): array => [$page->slug => [
                    'group' => $page->group->key,
                    'number' => $page->number,
                    'icon' => $page->icon,
                    'title' => $page->title,
                    'description' => $page->description,
                    'sections' => $page->sections->pluck('heading', 'anchor')->all(),
                ]])->all(),
                'groupLabels' => DocGroup::ordered()->get()->pluck('name', 'key')->all(),
                'tasks' => DocTask::ordered()->with('page')->get()
                    ->filter(fn (DocTask $task): bool => $titles->has($task->page?->slug))
                    ->map(fn (DocTask $task): array => [
                        'icon' => $task->icon,
                        'page' => $task->page->slug,
                        'anchor' => $task->anchor,
                        'title' => $task->title,
                        'pageTitle' => $titles[$task->page->slug],
                    ])->values()->all(),
            ];
        });
    }

    private function key(string $name): string
    {
        $version = Cache::rememberForever(self::VERSION_KEY, fn (): string => (string) Str::uuid());

        return "docs.{$version}.".app()->getLocale().".{$name}";
    }
}
