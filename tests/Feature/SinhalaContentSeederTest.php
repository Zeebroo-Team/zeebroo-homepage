<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Feature;
use App\Models\Industry;
use Database\Seeders\BlogSeeder;
use Database\Seeders\FeatureSeeder;
use Database\Seeders\IndustrySeeder;
use Database\Seeders\SinhalaContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SinhalaContentSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed([FeatureSeeder::class, IndustrySeeder::class]);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function dataFiles(): array
    {
        return ['features' => ['features'], 'industries' => ['industries']];
    }

    #[DataProvider('dataFiles')]
    public function test_sinhala_data_lines_up_with_the_english_data(string $file): void
    {
        $english = require database_path("seeders/data/{$file}.php");
        $sinhala = require database_path("seeders/data/{$file}.si.php");

        $this->assertSame(array_keys($english), array_keys($sinhala));

        foreach ($english as $slug => $en) {
            $si = $sinhala[$slug];
            $this->assertCount(count($en['highlights']), $si['highlights'], "{$slug} highlights");
            $this->assertCount(count($en['capabilities']), $si['capabilities'], "{$slug} capabilities");
            $this->assertSame($en['badge'] === null, $si['badge'] === null, "{$slug} badge");
            $this->assertLessThanOrEqual(32, mb_strlen((string) $si['badge']), "{$slug} badge length");
            $this->assertLessThanOrEqual(500, mb_strlen($si['description']), "{$slug} description length");
        }
    }

    public function test_it_fills_sinhala_columns_of_the_starter_content(): void
    {
        $this->seed(SinhalaContentSeeder::class);

        $feature = Feature::firstWhere('slug', 'point-of-sale');
        $this->assertSame('විකුණුම් ස්ථානය (POS)', $feature->title_si);
        $this->assertSame('ජනප්‍රිය', $feature->badge_si);
        $this->assertSame(['title' => 'ස්කෑන් කරන්න හෝ සොයන්න', 'text' => 'බාර්කෝඩ්, නම හෝ කාණ්ඩය අනුව භාණ්ඩ සොයා එක් ස්පර්ශයකින් කරත්තයට එක් කරන්න.'], $feature->highlights_si[0]);
        $this->assertCount(6, $feature->capabilities_si);
        $this->assertNotNull($feature->meta_description_si);
        $this->assertNull(Feature::firstWhere('slug', 'accounting')->badge_si);

        $industry = Industry::firstWhere('slug', 'restaurant');
        $this->assertSame('ආපනශාලා', $industry->title_si);
        $this->assertCount(3, $industry->highlights_si);
        $this->assertCount(6, $industry->capabilities_si);

        $this->assertSame(0, Feature::whereNull('title_si')->count());
        $this->assertSame(0, Industry::whereNull('title_si')->count());
    }

    public function test_it_keeps_admin_edits(): void
    {
        $feature = Feature::firstWhere('slug', 'point-of-sale');
        $feature->update(['title_si' => 'මගේ මාතෘකාව', 'headline' => 'A new English headline']);
        $industry = Industry::firstWhere('slug', 'restaurant');
        $industry->update([
            'highlights' => [['icon' => 'fa-star', 'title' => 'Changed', 'text' => '']],
            'capabilities' => ['Only one'],
        ]);

        $this->seed(SinhalaContentSeeder::class);

        $feature->refresh();
        $this->assertSame('මගේ මාතෘකාව', $feature->title_si);
        $this->assertNull($feature->headline_si);
        $this->assertNotNull($feature->lead_si);

        $industry->refresh();
        $this->assertNull($industry->highlights_si);
        $this->assertNull($industry->capabilities_si);
        $this->assertSame('ආපනශාලා', $industry->title_si);
    }

    public function test_sinhala_blog_data_lines_up_with_the_blog_seeder(): void
    {
        $sinhala = require database_path('seeders/data/blogs.si.php');

        $this->assertSame(array_column(BlogSeeder::CATEGORIES, 'slug'), array_keys($sinhala['categories']));
        $this->assertSame(array_column(BlogSeeder::posts(), 'slug'), array_keys($sinhala['posts']));

        foreach (BlogSeeder::posts() as $en) {
            $si = $sinhala['posts'][$en['slug']];
            $this->assertLessThanOrEqual(500, mb_strlen($si['meta_description']), "{$en['slug']} meta description length");

            foreach (['<h2>', '<li>', '<p>', '<blockquote>', '<strong>', '<em>'] as $tag) {
                $this->assertSame(substr_count($en['body'], $tag), substr_count($si['body'], $tag), "{$en['slug']} {$tag} count");
            }
        }
    }

    public function test_blog_seeder_writes_sinhala_content(): void
    {
        $this->seed(BlogSeeder::class);

        $this->assertSame('මූල්‍ය සහ ගිණුම්කරණය', BlogCategory::firstWhere('slug', 'finance-accounting')->name_si);
        $this->assertSame(0, BlogCategory::whereNull('name_si')->orWhereNull('description_si')->count());

        $blog = Blog::firstWhere('slug', 'introducing-the-zeebroo-ai-agent');
        $this->assertSame('Zeebroo AI සහායක හඳුන්වා දීම: ඔබේ ව්‍යාපාරයෙන් ඕනෑම දෙයක් අසන්න', $blog->title_si);
        $this->assertStringStartsWith('<p>', $blog->description_si);
        $this->assertSame(0, Blog::whereNull('title_si')->orWhereNull('description_si')->orWhereNull('meta_description_si')->count());
    }

    public function test_it_fills_blank_sinhala_blog_columns_and_keeps_admin_edits(): void
    {
        $this->seed(BlogSeeder::class);
        Blog::query()->update(['title_si' => null, 'meta_title_si' => null, 'meta_description_si' => null, 'meta_keywords_si' => null, 'description_si' => null]);
        BlogCategory::query()->update(['name_si' => null, 'description_si' => null]);

        $edited = Blog::firstWhere('slug', 'month-end-close-in-a-day');
        $edited->update(['title_si' => 'මගේ මාතෘකාව', 'description' => '<p>Rewritten in the admin panel.</p>']);

        $this->seed(SinhalaContentSeeder::class);

        $edited->refresh();
        $this->assertSame('මගේ මාතෘකාව', $edited->title_si);
        $this->assertNull($edited->description_si);
        $this->assertNotNull($edited->meta_description_si);

        $this->assertSame(1, Blog::whereNull('description_si')->count());
        $this->assertSame(0, BlogCategory::whereNull('name_si')->count());
    }
}
