<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\Industry;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminIndustryTest extends TestCase
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

    public function test_admin_industry_pages_render(): void
    {
        $industry = Industry::factory()->create();
        $industry->modules()->attach(Feature::factory()->create());
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.industries.index'))->assertOk()->assertSee($industry->title);
        $this->get(route('admin.industries.create'))->assertOk();
        $this->get(route('admin.industries.edit', $industry))->assertOk();
    }

    public function test_editor_can_create_an_industry_with_modules_scene_and_seo(): void
    {
        Storage::fake('public');
        $second = Feature::factory()->create();
        $first = Feature::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.industries.store'), [
            'title' => 'Bakery Shops',
            'slug' => '',
            'menu' => 'Bread and pastries',
            'icon' => 'fa-bread-slice',
            'badge' => 'New',
            'headline' => 'Fresh bread, fresh numbers',
            'lead' => 'Bake to demand.',
            'highlights' => [
                ['icon' => 'fa-star', 'title' => 'Daily batches', 'text' => 'Plan each bake.'],
                ['icon' => '', 'title' => '', 'text' => ''],
            ],
            'capabilities' => "Batch baking\n\nWholesale orders\n",
            'modules' => [$first->id, $second->id],
            'scene' => UploadedFile::fake()->image('scene.png'),
            'meta_title' => 'Bakery | POS',
            'meta_description' => 'POS for bakeries',
            'meta_keywords' => 'bakery, pos',
            'sort_order' => 3,
            'is_active' => '1',
        ])->assertRedirect(route('admin.industries.index'));

        $industry = Industry::firstWhere('title', 'Bakery Shops');
        $this->assertSame('bakery-shops', $industry->slug);
        $this->assertSame([['icon' => 'fa-star', 'title' => 'Daily batches', 'text' => 'Plan each bake.']], $industry->highlights);
        $this->assertSame(['Batch baking', 'Wholesale orders'], $industry->capabilities);
        $this->assertSame([$first->id, $second->id], $industry->modules->pluck('id')->all());
        $this->assertTrue($industry->is_active);
        Storage::disk('public')->assertExists($industry->scene_path);

        $this->get(route('industries.show', $industry->slug))->assertOk()->assertSee('Bake to demand.');
    }

    public function test_update_replaces_scene_and_can_deactivate(): void
    {
        Storage::fake('public');
        $oldScene = UploadedFile::fake()->image('old.png')->store('industries', 'public');
        $industry = Industry::factory()->create(['scene_path' => $oldScene]);
        $industry->modules()->attach(Feature::factory()->create());
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.industries.update', $industry), [
            'title' => $industry->title,
            'slug' => $industry->slug,
            'icon' => $industry->icon,
            'is_active' => '0',
            'scene' => UploadedFile::fake()->image('new.png'),
        ])->assertRedirect(route('admin.industries.index'));

        $industry->refresh();
        $this->assertFalse($industry->is_active);
        $this->assertCount(0, $industry->modules);
        Storage::disk('public')->assertMissing($oldScene);
        Storage::disk('public')->assertExists($industry->scene_path);

        $this->get(route('industries.show', $industry->slug))->assertNotFound();
    }

    public function test_industry_stores_sinhala_content(): void
    {
        $industry = Industry::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.industries.update', $industry), [
            'title' => 'Restaurants',
            'title_si' => 'ආපනශාලා',
            'slug' => $industry->slug,
            'menu_si' => 'මේස සහ කුස්සිය',
            'headline_si' => 'මේසයේ සිට කුස්සියට',
            'lead_si' => 'ඇණවුම් නැති නොවේ.',
            'badge_si' => 'ජනප්‍රිය',
            'icon' => 'fa-utensils',
            'highlights' => [
                ['icon' => 'fa-bolt', 'title' => 'Fast', 'text' => 'Quick orders.', 'title_si' => 'වේගවත්', 'text_si' => 'ඉක්මන් ඇණවුම්.'],
                ['icon' => '', 'title' => '', 'text' => '', 'title_si' => '', 'text_si' => ''],
                ['icon' => 'fa-print', 'title' => 'Tickets', 'text' => '', 'title_si' => '', 'text_si' => ''],
            ],
            'capabilities' => "Table layout\nKitchen tickets",
            'capabilities_si' => "මේස සැලැස්ම\n\nකුස්සි ටිකට්\n",
            'meta_title_si' => 'ආපනශාලා POS',
            'meta_description_si' => 'ආපනශාලා සඳහා POS',
            'meta_keywords_si' => 'ආපනශාලා, pos',
            'is_active' => '1',
        ])->assertRedirect(route('admin.industries.index'));

        $industry->refresh();
        $this->assertSame('ආපනශාලා', $industry->title_si);
        $this->assertSame('මේස සහ කුස්සිය', $industry->menu_si);
        $this->assertSame('මේසයේ සිට කුස්සියට', $industry->headline_si);
        $this->assertSame('ඇණවුම් නැති නොවේ.', $industry->lead_si);
        $this->assertSame('ජනප්‍රිය', $industry->badge_si);
        $this->assertSame([
            ['icon' => 'fa-bolt', 'title' => 'Fast', 'text' => 'Quick orders.'],
            ['icon' => 'fa-print', 'title' => 'Tickets', 'text' => ''],
        ], $industry->highlights);
        $this->assertSame([
            ['title' => 'වේගවත්', 'text' => 'ඉක්මන් ඇණවුම්.'],
            ['title' => '', 'text' => ''],
        ], $industry->highlights_si);
        $this->assertSame(['මේස සැලැස්ම', 'කුස්සි ටිකට්'], $industry->capabilities_si);
        $this->assertSame('ආපනශාලා POS', $industry->meta_title_si);
        $this->assertSame('ආපනශාලා සඳහා POS', $industry->meta_description_si);
        $this->assertSame('ආපනශාලා, pos', $industry->meta_keywords_si);

        $this->get(route('admin.industries.edit', $industry))->assertOk()
            ->assertSee('ආපනශාලා')
            ->assertSee('ඉක්මන් ඇණවුම්.')
            ->assertSee('කුස්සි ටිකට්');
    }

    public function test_deleting_an_industry_removes_its_scene(): void
    {
        Storage::fake('public');
        $scene = UploadedFile::fake()->image('scene.png')->store('industries', 'public');
        $industry = Industry::factory()->create(['scene_path' => $scene]);
        $this->actingAs($this->userWithRole('editor'));

        $this->delete(route('admin.industries.destroy', $industry))->assertRedirect(route('admin.industries.index'));

        $this->assertModelMissing($industry);
        Storage::disk('public')->assertMissing($scene);
    }

    public function test_validation_rejects_bad_icons_duplicate_slugs_and_unknown_modules(): void
    {
        Industry::factory()->create(['slug' => 'taken']);
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.industries.store'), ['title' => 'X', 'slug' => 'taken', 'icon' => 'not an icon', 'modules' => [999]])
            ->assertSessionHasErrors(['slug', 'icon', 'modules.0']);
    }

    public function test_industry_permissions_are_enforced(): void
    {
        $industry = Industry::factory()->create();
        $this->actingAs($this->userWithRole('author'));

        $this->get(route('admin.industries.index'))->assertForbidden();
        $this->get(route('admin.industries.create'))->assertForbidden();
        $this->delete(route('admin.industries.destroy', $industry))->assertForbidden();
    }
}
