<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\Industry;
use App\Models\Partner;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_and_footer_link_to_the_internal_about_page(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('about'))
            ->assertDontSee('https://www.zeebroo.com/about');
    }

    public function test_about_page_renders_without_any_content(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Built for the counter, not the boardroom.')
            ->assertSee('Six promises behind every screen.')
            ->assertSee('From first call to first sale.')
            ->assertDontSee('Businesses that count on us.');
    }

    public function test_about_page_lists_active_modules_and_industries(): void
    {
        $feature = Feature::factory()->create(['title' => 'Smart Stock']);
        $hiddenFeature = Feature::factory()->inactive()->create(['title' => 'Hidden Module']);
        $industry = Industry::factory()->create(['title' => 'Bakeries']);
        $hiddenIndustry = Industry::factory()->inactive()->create(['title' => 'Hidden Trade']);

        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Everything a business runs on.')
            ->assertSee(route('features.show', $feature->slug))
            ->assertSee(route('industries.show', $industry->slug))
            ->assertSee('1 module, one login')
            ->assertDontSee($hiddenFeature->title)
            ->assertDontSee($hiddenIndustry->title);
    }

    public function test_about_page_shows_featured_partners_and_testimonials_with_live_figures(): void
    {
        $featured = Partner::factory()->featured()->create(['name' => 'Featured Foods']);
        Partner::factory()->create(['name' => 'Plain Partner']);
        Partner::factory()->featured()->inactive()->create(['name' => 'Hidden Partner']);
        Testimonial::factory()->featured()->create(['name' => 'Featured Fernando', 'rating' => 5]);
        Testimonial::factory()->create(['name' => 'Plain Perera', 'rating' => 4]);

        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Businesses that count on us.')
            ->assertSee($featured->name)
            ->assertSee('Featured Fernando')
            ->assertSee('Read all 2 reviews')
            ->assertSee('4.5')
            ->assertSee(route('partners.index'))
            ->assertDontSee('Plain Partner')
            ->assertDontSee('Hidden Partner')
            ->assertDontSee('Plain Perera');
    }
}
