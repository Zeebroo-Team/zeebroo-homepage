<?php

namespace Database\Seeders;

use App\Models\DocGroup;
use App\Models\DocPage;
use App\Models\DocSection;
use App\Models\DocTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Imports the Zeebroo POS user guide from database/seeders/data/docs.php and the page bodies in
 * data/docs/{slug}.html (+ {slug}_si.html). Each body is cut, as written, into the HTML before
 * the first section (intro), one record per section, and the HTML after the last one (outro).
 * Runs only while the doc_pages table is empty, so it never overwrites changes made in the admin panel.
 */
class DocSeeder extends Seeder
{
    /**
     * Elements that never have a closing tag.
     */
    private const VOID_ELEMENTS = ['area', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'source', 'track', 'wbr'];

    public function run(): void
    {
        if (DocPage::query()->exists()) {
            return;
        }

        /** @var array{groups: array<string, string>, groups_si: array<string, string>, tasks: list<array<string, string>>, pages: array<string, array<string, mixed>>} $data */
        $data = require database_path('seeders/data/docs.php');

        DB::transaction(function () use ($data): void {
            $groups = collect($data['groups'])->map(fn (string $name, string $key) => DocGroup::create([
                'key' => $key,
                'name' => $name,
                'name_si' => $data['groups_si'][$key] ?? null,
                'sort_order' => array_search($key, array_keys($data['groups']), true),
            ]));

            $pages = collect($data['pages'])->map(fn (array $page, string $slug) => $this->createPage(
                $slug,
                $page,
                $groups[$page['group']],
                array_search($slug, array_keys($data['pages']), true),
            ));

            foreach ($data['tasks'] as $order => $task) {
                DocTask::create([
                    'doc_page_id' => $pages[$task['page']]->id,
                    'anchor' => $task['anchor'],
                    'icon' => $task['icon'],
                    'title' => $task['title'],
                    'title_si' => $task['title_si'] ?? null,
                    'sort_order' => $order,
                ]);
            }
        });
    }

    /**
     * @param  array<string, mixed>  $page
     */
    private function createPage(string $slug, array $page, DocGroup $group, int $order): DocPage
    {
        $english = $this->split($this->body($slug), $page['sections'], $slug);
        $sinhala = $this->split($this->body("{$slug}_si"), $page['sections_si'] ?? [], "{$slug}_si");

        if (array_keys($english['sections']) !== array_keys($sinhala['sections'])) {
            throw new RuntimeException("Docs page {$slug}: the Sinhala copy has different sections.");
        }

        $docPage = DocPage::create([
            'doc_group_id' => $group->id,
            'slug' => $slug,
            'number' => $page['number'],
            'icon' => $page['icon'],
            'title' => $page['title'],
            'title_si' => $page['title_si'] ?? null,
            'description' => $page['description'],
            'description_si' => $page['description_si'] ?? null,
            'intro' => $english['intro'],
            'intro_si' => $sinhala['intro'],
            'outro' => $english['outro'],
            'outro_si' => $sinhala['outro'],
            'sort_order' => $order,
            'is_active' => true,
        ]);

        foreach (array_values($english['sections']) as $position => $section) {
            $translation = $sinhala['sections'][$section['anchor']];

            DocSection::create([
                'doc_page_id' => $docPage->id,
                'anchor' => $section['anchor'],
                'heading' => $section['heading'],
                'heading_si' => $translation['heading'],
                'body' => $section['body'],
                'body_si' => $translation['body'],
                'is_custom' => $section['is_custom'],
                'sort_order' => $position,
            ]);
        }

        return $docPage;
    }

    private function body(string $file): string
    {
        return file_get_contents(database_path("seeders/data/docs/{$file}.html")) ?: '';
    }

    /**
     * Cuts a page body into intro, sections and outro. A top-level <div class="doc-sec"> that starts with
     * <h3 id="…"> is a standard section; any other top-level element whose id is listed in $headings
     * (anchor => heading) is a custom section kept whole. Top-level comments are dropped.
     *
     * @param  array<string, string>  $headings
     * @return array{intro: ?string, outro: ?string, sections: array<string, array{anchor: string, heading: string, body: string, is_custom: bool}>}
     */
    private function split(string $html, array $headings, string $file): array
    {
        $intro = [];
        $outro = [];
        $sections = [];

        foreach ($this->topLevelElements($html, $file) as $element) {
            $section = $this->section($element, $headings);

            if ($section !== null) {
                if ($outro !== []) {
                    throw new RuntimeException("Docs body {$file}: content between sections that is not a section.");
                }
                $sections[$section['anchor']] = $section;
            } elseif ($sections === []) {
                $intro[] = $element;
            } else {
                $outro[] = $element;
            }
        }

        return [
            'intro' => $intro === [] ? null : implode("\n\n", $intro),
            'outro' => $outro === [] ? null : implode("\n\n", $outro),
            'sections' => $sections,
        ];
    }

    /**
     * @param  array<string, string>  $headings
     * @return array{anchor: string, heading: string, body: string, is_custom: bool}|null
     */
    private function section(string $element, array $headings): ?array
    {
        if (preg_match('/^<div class="doc-sec">\s*<h3 id="([^"]+)">(.*?)<\/h3>(.*)<\/div>$/s', $element, $match)) {
            return [
                'anchor' => $match[1],
                'heading' => html_entity_decode(strip_tags($match[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                'body' => trim($match[3]),
                'is_custom' => false,
            ];
        }

        if (preg_match('/^<[a-z][a-z0-9]*\b[^>]*\bid="([^"]+)"/', $element, $match) && isset($headings[$match[1]])) {
            return ['anchor' => $match[1], 'heading' => $headings[$match[1]], 'body' => $element, 'is_custom' => true];
        }

        return null;
    }

    /**
     * Every top-level element of an HTML fragment, exactly as written.
     *
     * @return list<string>
     */
    private function topLevelElements(string $html, string $file): array
    {
        preg_match_all('/<!--.*?-->|<(\/?)([a-zA-Z][a-zA-Z0-9-]*)\b[^>]*?(\/?)>/s', $html, $tags, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

        $elements = [];
        $depth = 0;
        $start = null;
        $cursor = 0;

        foreach ($tags as $tag) {
            [$text, $offset] = $tag[0];
            $end = $offset + strlen($text);

            if (str_starts_with($text, '<!--')) {
                if ($depth === 0) {
                    $this->assertBlank(substr($html, $cursor, $offset - $cursor), $file);
                    $cursor = $end;
                }

                continue;
            }

            $isClosing = $tag[1][0] === '/';
            $isVoid = $tag[3][0] === '/' || in_array(strtolower($tag[2][0]), self::VOID_ELEMENTS, true);

            if ($depth === 0) {
                $this->assertBlank(substr($html, $cursor, $offset - $cursor), $file);
                $start = $offset;
            }

            if ($isClosing) {
                $depth--;
            } elseif (! $isVoid) {
                $depth++;
            }

            if ($depth < 0) {
                throw new RuntimeException("Docs body {$file}: unbalanced closing tag at byte {$offset}.");
            }

            if ($depth === 0) {
                $elements[] = substr($html, $start, $end - $start);
                $cursor = $end;
            }
        }

        if ($depth !== 0) {
            throw new RuntimeException("Docs body {$file}: unclosed element.");
        }

        $this->assertBlank(substr($html, $cursor), $file);

        return $elements;
    }

    private function assertBlank(string $text, string $file): void
    {
        if (trim($text) !== '') {
            throw new RuntimeException("Docs body {$file}: text outside any element: ".mb_substr(trim($text), 0, 40));
        }
    }
}
