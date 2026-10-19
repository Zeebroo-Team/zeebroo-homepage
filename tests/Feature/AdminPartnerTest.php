<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPartnerTest extends TestCase
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

    public function test_admin_partner_pages_render(): void
    {
        $partner = Partner::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.partners.index'))->assertOk()->assertSee($partner->name)->assertSee($partner->category->name);
        $this->get(route('admin.partners.index', ['category' => $partner->partner_category_id]))->assertOk()->assertSee($partner->name);
        $this->get(route('admin.partners.create'))->assertOk();
        $this->get(route('admin.partners.edit', $partner))->assertOk();
        $this->get(route('admin.partner-categories.index'))->assertOk()->assertSee($partner->category->name);
        $this->get(route('admin.partner-categories.create'))->assertOk();
        $this->get(route('admin.partner-categories.edit', $partner->category))->assertOk();
    }

    public function test_editor_can_create_a_partner_with_logo_and_details(): void
    {
        Storage::fake('public');
        $category = PartnerCategory::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.partners.store'), [
            'name' => 'Acme Payments',
            'partner_category_id' => $category->id,
            'tagline' => 'Card terminals',
            'description' => 'Takes card payments at the till.',
            'website_url' => 'acme.example.com',
            'location' => 'Colombo, Sri Lanka',
            'since_year' => 2024,
            'logo' => UploadedFile::fake()->image('logo.png'),
            'is_featured' => '1',
            'is_active' => '1',
            'sort_order' => 2,
        ])->assertRedirect(route('admin.partners.index'));

        $partner = Partner::firstWhere('name', 'Acme Payments');
        $this->assertSame($category->id, $partner->partner_category_id);
        $this->assertSame('https://acme.example.com', $partner->website_url);
        $this->assertSame(2024, $partner->since_year);
        $this->assertTrue($partner->is_featured);
        Storage::disk('public')->assertExists($partner->logo_path);

        $this->get(route('home'))->assertOk()->assertSee('Acme Payments')->assertSee($partner->logo_url);
    }

    public function test_update_replaces_logo_and_remove_logo_clears_it(): void
    {
        Storage::fake('public');
        $oldLogo = UploadedFile::fake()->image('old.png')->store('partners', 'public');
        $partner = Partner::factory()->create(['logo_path' => $oldLogo]);
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.partners.update', $partner), [
            'name' => $partner->name,
            'logo' => UploadedFile::fake()->image('new.png'),
            'is_active' => '1',
        ])->assertRedirect(route('admin.partners.index'));

        $partner->refresh();
        $this->assertNull($partner->partner_category_id);
        $this->assertFalse($partner->is_featured);
        Storage::disk('public')->assertMissing($oldLogo);
        Storage::disk('public')->assertExists($newLogo = $partner->logo_path);

        $this->put(route('admin.partners.update', $partner), ['name' => $partner->name, 'remove_logo' => '1'])
            ->assertRedirect(route('admin.partners.index'));

        $this->assertNull($partner->fresh()->logo_path);
        Storage::disk('public')->assertMissing($newLogo);
    }

    public function test_deleting_a_partner_removes_its_logo(): void
    {
        Storage::fake('public');
        $logo = UploadedFile::fake()->image('logo.png')->store('partners', 'public');
        $partner = Partner::factory()->create(['logo_path' => $logo]);
        $this->actingAs($this->userWithRole('editor'));

        $this->delete(route('admin.partners.destroy', $partner))->assertRedirect(route('admin.partners.index'));

        $this->assertModelMissing($partner);
        Storage::disk('public')->assertMissing($logo);
    }

    public function test_partner_validation_rejects_bad_data(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.partners.store'), [
            'name' => '',
            'partner_category_id' => 999,
            'website_url' => 'not a url',
            'since_year' => 1500,
            'logo' => UploadedFile::fake()->create('logo.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors(['name', 'partner_category_id', 'website_url', 'since_year', 'logo']);
    }

    public function test_editor_can_manage_partner_categories(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.partner-categories.store'), [
            'name' => 'Payment Partners',
            'icon' => 'fa-credit-card',
            'is_active' => '1',
        ])->assertRedirect(route('admin.partner-categories.index'));

        $category = PartnerCategory::firstWhere('name', 'Payment Partners');
        $this->assertSame('payment-partners', $category->slug);

        $partner = Partner::factory()->for($category, 'category')->create();
        $this->delete(route('admin.partner-categories.destroy', $category))->assertRedirect(route('admin.partner-categories.index'));

        $this->assertModelMissing($category);
        $this->assertNull($partner->fresh()->partner_category_id);

        $this->post(route('admin.partner-categories.store'), ['name' => 'X', 'icon' => 'not an icon'])->assertSessionHasErrors('icon');
    }

    public function test_editor_can_toggle_a_partner_onto_the_home_page(): void
    {
        $partner = Partner::factory()->create(['name' => 'Toggle Foods']);
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('home'))->assertDontSee('Toggle Foods');

        $this->from(route('admin.partners.index'))
            ->patch(route('admin.partners.featured', $partner))
            ->assertRedirect(route('admin.partners.index'));

        $this->assertTrue($partner->fresh()->is_featured);
        $this->get(route('home'))->assertSee('Toggle Foods');

        $this->patch(route('admin.partners.featured', $partner));

        $this->assertFalse($partner->fresh()->is_featured);
    }

    public function test_featured_inactive_partner_stays_off_the_home_page(): void
    {
        $partner = Partner::factory()->inactive()->create(['name' => 'Sleeping Foods']);
        $this->actingAs($this->userWithRole('editor'));

        $this->patch(route('admin.partners.featured', $partner))->assertSessionHas('status');

        $this->assertTrue($partner->fresh()->is_featured);
        $this->get(route('home'))->assertDontSee('Sleeping Foods');
        $this->get(route('admin.partners.index'))->assertSee('Featured · hidden');
    }

    public function test_admin_partner_list_filters_by_home_page(): void
    {
        $featured = Partner::factory()->featured()->create(['name' => 'Starred Partner']);
        $plain = Partner::factory()->create(['name' => 'Plain Partner']);
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.partners.index', ['home' => 'featured']))
            ->assertSee($featured->name)
            ->assertDontSee($plain->name);

        $this->get(route('admin.partners.index', ['home' => 'not-featured']))
            ->assertSee($plain->name)
            ->assertDontSee($featured->name);
    }

    public function test_partner_permissions_are_enforced(): void
    {
        $partner = Partner::factory()->create();
        $this->actingAs($this->userWithRole('author'));

        $this->patch(route('admin.partners.featured', $partner))->assertForbidden();
        $this->get(route('admin.partners.index'))->assertForbidden();
        $this->get(route('admin.partners.create'))->assertForbidden();
        $this->delete(route('admin.partners.destroy', $partner))->assertForbidden();
        $this->get(route('admin.partner-categories.index'))->assertForbidden();
        $this->delete(route('admin.partner-categories.destroy', $partner->category))->assertForbidden();
    }
}
