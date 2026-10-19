<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HomePackagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_package_summaries_with_view_details_links(): void
    {
        Http::fake(['*/api/v1/pos/auth/packages' => Http::response(['data' => [
            [
                'slug' => 'growth',
                'name' => 'Growth',
                'description' => 'For shops that are scaling up.',
                'price' => 5000,
                'discounted_price' => 4000,
                'currency_symbol' => 'Rs ',
                'features' => ['pos', 'stock', 'accounts', 'crm', 'hr', 'bills'],
            ],
        ]])]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="pricing"', false)
            ->assertSee('Growth')
            ->assertSee('Rs 4,000')
            ->assertSee('Save 20%')
            ->assertSee('For shops that are scaling up.')
            ->assertSee('6 modules included')
            ->assertSee('+2 more modules')
            ->assertSee('View details')
            ->assertSee(route('packages.show', 'growth'))
            ->assertSee(route('packages.index'));
    }

    public function test_home_page_hides_pricing_section_when_packages_are_unavailable(): void
    {
        Http::fake(['*/api/v1/pos/auth/packages' => Http::response([], 500)]);

        $this->get(route('home'))->assertOk()->assertDontSee('id="pricing"', false);
    }
}
