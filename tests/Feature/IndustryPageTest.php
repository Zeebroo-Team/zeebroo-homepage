<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\Industry;
use Database\Seeders\FeatureSeeder;
use Database\Seeders\IndustrySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IndustryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_mega_menu_home_and_index_list_only_active_industries(): void
    {
        $shown = Industry::factory()->create(['title' => 'Bakery Shops', 'menu' => 'Bread and pastries']);
        $hidden = Industry::factory()->inactive()->create(['title' => 'Hidden Trade']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('All 1 industries')
            ->assertSee('Bread and pastries')
            ->assertSee(route('industries.show', $shown->slug))
            ->assertDontSee($hidden->title);

        $this->get(route('industries.index'))
            ->assertOk()
            ->assertSee($shown->title)
            ->assertDontSee($hidden->title);
    }

    public function test_show_renders_seo_highlights_and_active_modules_in_order(): void
    {
        $industry = Industry::factory()->create([
            'meta_title' => 'Bakery POS',
            'meta_keywords' => 'bakery, pos',
            'highlights' => [['icon' => 'fa-bread-slice', 'title' => 'Fresh every day', 'text' => 'Bake to demand.']],
            'capabilities' => ['Batch baking'],
        ]);
        $second = Feature::factory()->create(['title' => 'Second Module']);
        $first = Feature::factory()->create(['title' => 'First Module']);
        $hiddenModule = Feature::factory()->inactive()->create(['title' => 'Hidden Module']);
        $industry->modules()->sync([
            $first->id => ['sort_order' => 0],
            $second->id => ['sort_order' => 1],
            $hiddenModule->id => ['sort_order' => 2],
        ]);

        $this->get(route('industries.show', $industry->slug))
            ->assertOk()
            ->assertSee('<title>Bakery POS | Zeebroo</title>', false)
            ->assertSee('<meta name="keywords" content="bakery, pos">', false)
            ->assertSee('Fresh every day')
            ->assertSee('Batch baking')
            ->assertSeeInOrder(['First Module', 'Second Module'])
            ->assertDontSee('Hidden Module');
    }

    public function test_inactive_and_unknown_industries_return_404(): void
    {
        $hidden = Industry::factory()->inactive()->create();

        $this->get(route('industries.show', $hidden->slug))->assertNotFound();
        $this->get(route('industries.show', 'nope'))->assertNotFound();
    }

    public function test_pager_wraps_around_in_menu_order(): void
    {
        $a = Industry::factory()->create(['title' => 'Alpha Trade', 'sort_order' => 0]);
        $b = Industry::factory()->create(['title' => 'Beta Trade', 'sort_order' => 1]);
        $c = Industry::factory()->create(['title' => 'Gamma Trade', 'sort_order' => 2]);

        $this->get(route('industries.show', $a->slug))
            ->assertOk()
            ->assertSee(route('industries.show', $c->slug))
            ->assertSee(route('industries.show', $b->slug));
    }

    public function test_seeder_imports_starter_industries_with_modules_once(): void
    {
        Storage::fake('public');
        $this->seed([FeatureSeeder::class, IndustrySeeder::class]);

        $restaurant = Industry::firstWhere('slug', 'restaurant');
        $this->assertSame(9, Industry::count());
        $this->assertSame('Popular', $restaurant->badge);
        $this->assertSame('restaurant', $restaurant->modules->first()->slug);
        Storage::disk('public')->assertExists($restaurant->scene_path);

        $restaurant->update(['title' => 'Edited in admin']);
        $this->seed(IndustrySeeder::class);
        $this->assertSame(9, Industry::count());
        $this->assertSame('Edited in admin', $restaurant->fresh()->title);
    }
}
