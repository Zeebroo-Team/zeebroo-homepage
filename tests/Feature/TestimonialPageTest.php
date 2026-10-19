<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_only_active_featured_testimonials(): void
    {
        $featured = Testimonial::factory()->featured()->create(['name' => 'Featured Fernando', 'position' => 'Owner, Fresh Mart']);
        $notFeatured = Testimonial::factory()->create(['name' => 'Plain Perera']);
        $inactive = Testimonial::factory()->featured()->inactive()->create(['name' => 'Hidden Herath']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($featured->name)
            ->assertSee('Owner, Fresh Mart')
            ->assertSee($featured->message)
            ->assertSee(route('testimonials.index'))
            ->assertDontSee($notFeatured->name)
            ->assertDontSee($inactive->name);
    }

    public function test_home_page_hides_the_section_without_featured_testimonials(): void
    {
        Testimonial::factory()->create();

        $this->get(route('home'))->assertOk()->assertDontSee('id="testimonials"', false);
    }

    public function test_index_lists_every_active_testimonial_in_order_with_average_rating(): void
    {
        Testimonial::factory()->create(['name' => 'Second Silva', 'sort_order' => 2, 'rating' => 4]);
        Testimonial::factory()->featured()->create(['name' => 'First Fonseka', 'sort_order' => 1, 'rating' => 5]);
        Testimonial::factory()->inactive()->create(['name' => 'Gone Gunawardena']);

        $this->get(route('testimonials.index'))
            ->assertOk()
            ->assertSeeInOrder(['First Fonseka', 'Second Silva'])
            ->assertSee('4.5')
            ->assertSee('4 out of 5 stars')
            ->assertDontSee('Gone Gunawardena');
    }

    public function test_index_shows_empty_state_without_testimonials(): void
    {
        $this->get(route('testimonials.index'))->assertOk()->assertSee('Customer stories are on their way');
    }
}
