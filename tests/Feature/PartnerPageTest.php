<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\PartnerCategory;
use Database\Seeders\PartnerCategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_only_active_featured_partners(): void
    {
        $featured = Partner::factory()->featured()->create(['name' => 'Featured Foods']);
        $notFeatured = Partner::factory()->create(['name' => 'Plain Partner']);
        $inactive = Partner::factory()->featured()->inactive()->create(['name' => 'Hidden Partner']);
        $hiddenCategory = Partner::factory()->featured()->for(PartnerCategory::factory()->inactive(), 'category')->create(['name' => 'Hidden Category Partner']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($featured->name)
            ->assertSee(route('partners.index'))
            ->assertDontSee($notFeatured->name)
            ->assertDontSee($inactive->name)
            ->assertDontSee($hiddenCategory->name);
    }

    public function test_home_page_hides_the_section_without_featured_partners(): void
    {
        Partner::factory()->create();

        $this->get(route('home'))->assertOk()->assertDontSee('id="partners"', false);
    }

    public function test_index_groups_active_partners_by_category_in_order(): void
    {
        $clients = PartnerCategory::factory()->create(['name' => 'Retail Clients', 'sort_order' => 1]);
        $tech = PartnerCategory::factory()->create(['name' => 'Tech Partners', 'sort_order' => 0]);
        PartnerCategory::factory()->create(['name' => 'Empty Group']);
        Partner::factory()->for($clients, 'category')->create(['name' => 'Corner Shop', 'location' => 'Kandy']);
        Partner::factory()->for($tech, 'category')->create(['name' => 'Cloud Co', 'since_year' => 2023, 'location' => 'Colombo']);
        Partner::factory()->create(['partner_category_id' => null, 'name' => 'Loose Partner']);
        Partner::factory()->inactive()->for($tech, 'category')->create(['name' => 'Gone Partner']);

        $this->get(route('partners.index'))
            ->assertOk()
            ->assertSeeInOrder(['Tech Partners', 'Cloud Co', 'Retail Clients', 'Corner Shop', 'More partners', 'Loose Partner'])
            ->assertSee('Since 2023')
            ->assertSee(route('partners.index', ['category' => $tech->slug]))
            ->assertDontSee('Empty Group')
            ->assertDontSee('Gone Partner');
    }

    public function test_category_filter_shows_one_category_and_404s_for_unknown(): void
    {
        $tech = PartnerCategory::factory()->create(['name' => 'Tech Partners']);
        $clients = PartnerCategory::factory()->create(['name' => 'Retail Clients']);
        Partner::factory()->for($tech, 'category')->create(['name' => 'Cloud Co']);
        Partner::factory()->for($clients, 'category')->create(['name' => 'Corner Shop']);

        $this->get(route('partners.index', ['category' => $tech->slug]))
            ->assertOk()
            ->assertSee('Cloud Co')
            ->assertDontSee('Corner Shop');

        $this->get(route('partners.index', ['category' => 'nope']))->assertNotFound();
    }

    public function test_index_shows_empty_state_without_partners(): void
    {
        $this->get(route('partners.index'))->assertOk()->assertSee('Our partner list is on its way');
    }

    public function test_seeder_creates_starter_categories_once(): void
    {
        $this->seed(PartnerCategorySeeder::class);
        $this->assertSame(4, PartnerCategory::count());

        PartnerCategory::first()->update(['name' => 'Edited in admin']);
        $this->seed(PartnerCategorySeeder::class);
        $this->assertSame(4, PartnerCategory::count());
        $this->assertSame('Edited in admin', PartnerCategory::first()->name);
    }
}
