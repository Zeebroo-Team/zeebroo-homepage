<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use App\Models\Feature;
use App\Models\FeatureScreenshot;
use Database\Seeders\FeatureSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FeaturePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_active_features_by_group(): void
    {
        $core = Feature::factory()->core()->create(['title' => 'Core Thing']);
        $suite = Feature::factory()->create(['title' => 'Suite Thing']);
        $hidden = Feature::factory()->inactive()->create(['title' => 'Hidden Thing']);

        $this->get(route('features.index'))
            ->assertOk()
            ->assertSee($core->title)
            ->assertSee($suite->title)
            ->assertDontSee($hidden->title);
    }

    public function test_show_renders_seo_screenshots_and_active_related_features(): void
    {
        $feature = Feature::factory()->create([
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom meta description',
            'meta_keywords' => 'pos, checkout',
        ]);
        $related = Feature::factory()->create(['title' => 'Related Active']);
        $hiddenRelated = Feature::factory()->inactive()->create(['title' => 'Related Hidden']);
        $feature->related()->sync([$related->id, $hiddenRelated->id]);
        FeatureScreenshot::factory()->for($feature)->create(['caption' => 'The checkout screen']);

        $this->get(route('features.show', $feature->slug))
            ->assertOk()
            ->assertSee('<title>Custom Meta Title | Zeebroo</title>', false)
            ->assertSee('content="Custom meta description"', false)
            ->assertSee('<meta name="keywords" content="pos, checkout">', false)
            ->assertSee('The checkout screen')
            ->assertSee($related->title)
            ->assertDontSee($hiddenRelated->title);
    }

    public function test_inactive_and_unknown_features_return_404(): void
    {
        $hidden = Feature::factory()->inactive()->create();

        $this->get(route('features.show', $hidden->slug))->assertNotFound();
        $this->get(route('features.show', 'does-not-exist'))->assertNotFound();
    }

    public function test_header_menu_and_home_page_read_features_from_the_database(): void
    {
        $core = Feature::factory()->core()->create(['title' => 'Menu Core', 'menu' => 'Shown in the mega menu']);
        $hidden = Feature::factory()->core()->inactive()->create(['title' => 'Menu Hidden']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Shown in the mega menu')
            ->assertSee('All 1 features')
            ->assertSee('id="modData"', false)
            ->assertDontSee($hidden->title);
    }

    public function test_seeder_imports_the_starter_modules_once(): void
    {
        Storage::fake('public');

        $this->seed(FeatureSeeder::class);

        $pos = Feature::firstWhere('slug', 'point-of-sale');
        $this->assertSame(19, Feature::count());
        $this->assertSame('core', $pos->group);
        $this->assertSame(['icon' => 'fa-barcode', 'title' => 'Scan or search'], array_slice($pos->highlights[0], 0, 2));
        $this->assertSame(['stock-management', 'sales-management', 'account-management'], $pos->related->pluck('slug')->all());
        Storage::disk('public')->assertExists($pos->spot_path);

        $pos->update(['title' => 'Edited in admin']);
        $this->seed(FeatureSeeder::class);
        $this->assertSame('Edited in admin', $pos->fresh()->title);
        $this->assertSame(19, Feature::count());
    }

    public function test_pos_page_has_its_own_sinhala_address_with_hreflang_links(): void
    {
        Feature::factory()->create([
            'slug' => 'point-of-sale',
            'meta_title' => 'POS System Sri Lanka | Web & Desktop',
            'meta_title_si' => 'ශ්‍රී ලංකාව සඳහා POS පද්ධතිය',
        ]);
        $english = route('features.show', 'point-of-sale');
        $sinhala = route('features.si', 'pos-system');

        $this->get($english)
            ->assertOk()
            ->assertSee('<html lang="en-LK">', false)
            ->assertSee('<title>POS System Sri Lanka | Web &amp; Desktop | Zeebroo</title>', false)
            ->assertSee('<link rel="canonical" href="'.$english.'">', false)
            ->assertSee('<link rel="alternate" hreflang="si-LK" href="'.$sinhala.'">', false)
            ->assertSee('<meta property="og:title" content="POS System Sri Lanka | Zeebroo">', false)
            ->assertSee('<meta name="twitter:description" content="Web and desktop POS software for Sri Lankan businesses.">', false)
            ->assertSee('<meta property="og:locale" content="en_LK">', false)
            ->assertSee('<meta property="og:locale:alternate" content="si_LK">', false);

        $this->get($sinhala)
            ->assertOk()
            ->assertCookie(SetLocale::COOKIE, 'si')
            ->assertSee('<html lang="si-LK">', false)
            ->assertSee('<title>ශ්‍රී ලංකාව සඳහා POS පද්ධතිය | Zeebroo</title>', false)
            ->assertSee('<link rel="canonical" href="'.$sinhala.'">', false)
            ->assertSee('<link rel="alternate" hreflang="en-LK" href="'.$english.'">', false)
            ->assertSee('<link rel="alternate" hreflang="x-default" href="'.$english.'">', false)
            ->assertSee('<meta property="og:title" content="ශ්‍රී ලංකාව සඳහා POS පද්ධතිය">', false)
            ->assertSee('<meta property="og:url" content="'.$sinhala.'">', false)
            ->assertSee('<meta property="og:locale" content="si_LK">', false);
    }

    public function test_features_without_a_sinhala_address_list_no_si_hreflang(): void
    {
        $feature = Feature::factory()->create();

        $this->get(route('features.show', $feature->slug))
            ->assertOk()
            ->assertDontSee('hreflang="si-LK"', false);

        $this->get(route('features.si', 'not-a-feature'))->assertNotFound();
    }
}
