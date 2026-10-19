<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Enquiry;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    private function userWithRole(string $role): User
    {
        return User::factory()->create()->assignRole($role);
    }

    public function test_dashboard_shows_summary_analytics_and_shortcuts(): void
    {
        Blog::factory()->create(['published_at' => now()->subDay()]);
        Blog::factory()->scheduled()->create(['title' => 'Coming soon post']);
        Blog::factory()->draft()->create();
        Enquiry::factory()->create(['name' => 'Nimal Perera', 'status' => 'new']);
        Enquiry::factory()->create(['status' => 'resolved']);

        $this->actingAs($this->userWithRole('editor'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Needs your attention')
            ->assertSee('1 new enquiry to reply to')
            ->assertSee('1 post is still a draft')
            ->assertSee('Enquiries per day')
            ->assertSee('Enquiry breakdown')
            ->assertSee('Website content')
            ->assertSee('Coming soon post')
            ->assertSee('Nimal Perera')
            ->assertSee('data-key="c p"', false)
            ->assertSee('Keyboard shortcuts');
    }

    public function test_dashboard_flags_enquiries_waiting_too_long(): void
    {
        Enquiry::factory()->count(2)->create(['status' => 'new', 'created_at' => now()->subDays(3)]);

        $this->actingAs($this->userWithRole('editor'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('2 enquiries have waited over 48 hours for a reply');
    }

    public function test_dashboard_compares_enquiries_with_previous_period(): void
    {
        Enquiry::factory()->count(3)->create(['created_at' => now()->subDays(2)]);
        Enquiry::factory()->count(2)->create(['created_at' => now()->subDays(40)]);

        $this->actingAs($this->userWithRole('editor'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('+50% vs previous 30 days')
            ->assertSee('Daily average')
            ->assertSee('Busiest day');
    }

    public function test_author_only_sees_blog_sections(): void
    {
        Enquiry::factory()->create(['name' => 'Hidden Person']);

        $this->actingAs($this->userWithRole('author'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Posts published')
            ->assertDontSee('Enquiries per day')
            ->assertDontSee('Hidden Person')
            ->assertDontSee('Website content')
            ->assertDontSee('data-key="c f"', false);
    }

    public function test_dashboard_says_all_caught_up_when_nothing_is_pending(): void
    {
        $this->actingAs($this->userWithRole('super-admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('All caught up');
    }
}
