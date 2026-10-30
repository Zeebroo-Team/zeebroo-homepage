<?php

namespace Tests\Feature;

use App\Models\DocGroup;
use App\Models\DocPage;
use App\Models\DocSection;
use App\Models\DocTask;
use App\Services\DocLibrary;
use Database\Seeders\DocSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DocSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_imports_every_group_page_section_and_task(): void
    {
        $this->seed(DocSeeder::class);

        /** @var array{groups: array<string, string>, tasks: list<array<string, string>>, pages: array<string, array<string, mixed>>} $data */
        $data = require database_path('seeders/data/docs.php');

        $this->assertSame(array_keys($data['groups']), DocGroup::ordered()->pluck('key')->all());
        $this->assertSame(array_keys($data['pages']), DocPage::ordered()->pluck('slug')->all());
        $this->assertSame(count($data['tasks']), DocTask::count());
        $this->assertSame(collect($data['pages'])->sum(fn (array $page) => count($page['sections'])), DocSection::count());

        foreach ($data['pages'] as $slug => $page) {
            $this->assertSame(array_keys($page['sections']), DocPage::firstWhere('slug', $slug)->sections->pluck('anchor')->all(), $slug);
        }
    }

    public function test_it_leaves_existing_docs_alone(): void
    {
        $page = DocPage::factory()->create(['title' => 'Edited in the admin']);

        $this->seed(DocSeeder::class);

        $this->assertSame(1, DocPage::count());
        $this->assertSame('Edited in the admin', $page->fresh()->title);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function locales(): array
    {
        return ['english' => ['en'], 'sinhala' => ['si']];
    }

    /**
     * The imported pages must show exactly what the old hard-coded chapter files showed.
     */
    #[DataProvider('locales')]
    public function test_every_imported_page_body_matches_the_old_chapter_file(string $locale): void
    {
        $this->seed(DocSeeder::class);
        app()->setLocale($locale);
        $library = app(DocLibrary::class);

        foreach (DocPage::pluck('slug') as $slug) {
            $old = view('frontend.docs.chapters.'.$slug)->render();

            $this->assertSame($this->normalise($old), $this->normalise((string) $library->body($slug)), "{$slug} ({$locale})");
        }
    }

    /**
     * Same markup, ignoring comments, whitespace between tags, entity spelling and the site address.
     */
    private function normalise(string $html): string
    {
        $html = str_replace(rtrim(url('/'), '/').'/', '/', $html);
        $html = preg_replace('/<!--.*?-->/s', '', $html);
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $html = preg_replace('/\s+/u', ' ', $html);

        return trim(preg_replace('/>\s+</', '><', $html));
    }
}
