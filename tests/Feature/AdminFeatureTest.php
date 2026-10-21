<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\FeatureScreenshot;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFeatureTest extends TestCase
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

    public function test_admin_feature_pages_render(): void
    {
        $feature = Feature::factory()->create();
        FeatureScreenshot::factory()->for($feature)->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.features.index'))->assertOk()->assertSee($feature->title);
        $this->get(route('admin.features.create'))->assertOk();
        $this->get(route('admin.features.edit', $feature))->assertOk();
    }

    public function test_editor_can_create_a_feature_with_images_screenshots_and_seo(): void
    {
        Storage::fake('public');
        $related = Feature::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.features.store'), [
            'title' => 'Loyalty Points',
            'slug' => '',
            'menu' => 'Rewards for regulars',
            'icon' => 'fa-gift',
            'group' => 'core',
            'badge' => 'New',
            'headline' => 'Bring customers back',
            'lead' => 'Reward every purchase.',
            'highlights' => [
                ['icon' => 'fa-star', 'title' => 'Earn', 'text' => 'Points on every sale.'],
                ['icon' => '', 'title' => '', 'text' => ''],
            ],
            'capabilities' => "Points per purchase\n\nRedeem at the till\n",
            'related' => [$related->id],
            'spot' => UploadedFile::fake()->image('spot.png'),
            'scene' => UploadedFile::fake()->image('scene.png'),
            'screenshots' => [UploadedFile::fake()->image('one.png'), UploadedFile::fake()->image('two.png')],
            'new_screenshot_captions' => ['First screen', ''],
            'meta_title' => 'Loyalty | POS',
            'meta_description' => 'Loyalty points for your shop',
            'meta_keywords' => 'loyalty, rewards',
            'sort_order' => 3,
            'is_active' => '1',
        ])->assertRedirect(route('admin.features.index'));

        $feature = Feature::firstWhere('title', 'Loyalty Points');
        $this->assertSame('loyalty-points', $feature->slug);
        $this->assertSame([['icon' => 'fa-star', 'title' => 'Earn', 'text' => 'Points on every sale.']], $feature->highlights);
        $this->assertSame(['Points per purchase', 'Redeem at the till'], $feature->capabilities);
        $this->assertSame('loyalty, rewards', $feature->meta_keywords);
        $this->assertTrue($feature->is_active);
        $this->assertSame([$related->id], $feature->related->pluck('id')->all());
        $this->assertCount(2, $feature->screenshots);
        $this->assertSame(['First screen', null], $feature->screenshots->pluck('caption')->all());
        Storage::disk('public')->assertExists([$feature->spot_path, $feature->scene_path, ...$feature->screenshots->pluck('path')]);

        $this->get(route('features.show', $feature->slug))->assertOk()->assertSee('Reward every purchase.');
    }

    public function test_update_can_edit_remove_and_add_screenshots_and_replace_images(): void
    {
        Storage::fake('public');
        $oldSpot = UploadedFile::fake()->image('old.png')->store('features', 'public');
        $feature = Feature::factory()->create(['spot_path' => $oldSpot]);
        $keep = FeatureScreenshot::factory()->for($feature)->create(['path' => UploadedFile::fake()->image('a.png')->store('features/screenshots', 'public')]);
        $drop = FeatureScreenshot::factory()->for($feature)->create(['path' => UploadedFile::fake()->image('b.png')->store('features/screenshots', 'public')]);
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.features.update', $feature), [
            'title' => $feature->title,
            'slug' => $feature->slug,
            'icon' => $feature->icon,
            'group' => 'suite',
            'is_active' => '0',
            'spot' => UploadedFile::fake()->image('new.png'),
            'screenshot_captions' => [$keep->id => 'Kept and captioned'],
            'screenshot_order' => [$keep->id => 5],
            'remove_screenshots' => [$drop->id],
            'screenshots' => [UploadedFile::fake()->image('c.png')],
        ])->assertRedirect(route('admin.features.index'));

        $feature->refresh();
        $this->assertFalse($feature->is_active);
        Storage::disk('public')->assertMissing($oldSpot);
        Storage::disk('public')->assertExists($feature->spot_path);
        Storage::disk('public')->assertMissing($drop->path);
        $this->assertModelMissing($drop);
        $this->assertSame('Kept and captioned', $keep->fresh()->caption);
        $this->assertSame(5, $keep->fresh()->sort_order);
        $this->assertSame($keep->id, $feature->screenshots->first()->id);
        $this->assertSame(6, $feature->screenshots->last()->sort_order);
        $this->assertCount(2, $feature->screenshots);

        $this->get(route('features.show', $feature->slug))->assertNotFound();
    }

    public function test_feature_stores_sinhala_content_and_screenshot_captions(): void
    {
        Storage::fake('public');
        $feature = Feature::factory()->create();
        $shot = FeatureScreenshot::factory()->for($feature)->create(['path' => UploadedFile::fake()->image('a.png')->store('features/screenshots', 'public')]);
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.features.update', $feature), [
            'title' => 'Point of Sale',
            'title_si' => 'විකුණුම් ස්ථානය',
            'slug' => $feature->slug,
            'menu_si' => 'වේගවත් ගෙවීම්',
            'headline_si' => 'පෝලිම ඉක්මනින් යන ගෙවීම්',
            'lead_si' => 'අයිතම ස්කෑන් කරන්න.',
            'badge_si' => 'නව',
            'icon' => 'fa-cash-register',
            'group' => 'core',
            'highlights' => [
                ['icon' => 'fa-bolt', 'title' => 'Fast', 'text' => 'Quick sales.', 'title_si' => 'වේගවත්', 'text_si' => 'ඉක්මන් විකුණුම්.'],
                ['icon' => '', 'title' => '', 'text' => '', 'title_si' => '', 'text_si' => ''],
                ['icon' => 'fa-print', 'title' => 'Receipts', 'text' => '', 'title_si' => '', 'text_si' => ''],
            ],
            'capabilities' => "Barcode scanning\nReceipts",
            'capabilities_si' => "බාර්කෝඩ් ස්කෑන් කිරීම\n\nරිසිට්පත්\nඅලෙවි වාර්තා\n",
            'meta_title_si' => 'POS | Zeebroo',
            'screenshot_captions' => [$shot->id => 'Checkout screen'],
            'screenshot_captions_si' => [$shot->id => 'ගෙවීම් තිරය'],
            'screenshots' => [UploadedFile::fake()->image('new.png')],
            'new_screenshot_captions' => ['Receipt'],
            'new_screenshot_captions_si' => ['රිසිට්පත'],
            'is_active' => '1',
        ])->assertRedirect(route('admin.features.index'));

        $feature->refresh();
        $this->assertSame('විකුණුම් ස්ථානය', $feature->title_si);
        $this->assertSame('වේගවත් ගෙවීම්', $feature->menu_si);
        $this->assertSame('පෝලිම ඉක්මනින් යන ගෙවීම්', $feature->headline_si);
        $this->assertSame('අයිතම ස්කෑන් කරන්න.', $feature->lead_si);
        $this->assertSame('නව', $feature->badge_si);
        $this->assertSame([
            ['icon' => 'fa-bolt', 'title' => 'Fast', 'text' => 'Quick sales.'],
            ['icon' => 'fa-print', 'title' => 'Receipts', 'text' => ''],
        ], $feature->highlights);
        $this->assertSame([
            ['title' => 'වේගවත්', 'text' => 'ඉක්මන් විකුණුම්.'],
            ['title' => '', 'text' => ''],
        ], $feature->highlights_si);
        $this->assertSame(['බාර්කෝඩ් ස්කෑන් කිරීම', 'රිසිට්පත්', 'අලෙවි වාර්තා'], $feature->capabilities_si);
        $this->assertSame('POS | Zeebroo', $feature->meta_title_si);
        $this->assertSame('ගෙවීම් තිරය', $shot->fresh()->caption_si);
        $this->assertSame('Checkout screen', $shot->fresh()->caption);
        $this->assertSame('රිසිට්පත', $feature->screenshots->last()->caption_si);

        $this->get(route('admin.features.edit', $feature))->assertOk()
            ->assertSee('විකුණුම් ස්ථානය')
            ->assertSee('ඉක්මන් විකුණුම්.')
            ->assertSee('ගෙවීම් තිරය');
    }

    public function test_deleting_a_feature_removes_its_files(): void
    {
        Storage::fake('public');
        $spot = UploadedFile::fake()->image('spot.png')->store('features', 'public');
        $feature = Feature::factory()->create(['spot_path' => $spot]);
        $shot = FeatureScreenshot::factory()->for($feature)->create(['path' => UploadedFile::fake()->image('s.png')->store('features/screenshots', 'public')]);
        $this->actingAs($this->userWithRole('editor'));

        $this->delete(route('admin.features.destroy', $feature))->assertRedirect(route('admin.features.index'));

        $this->assertModelMissing($feature);
        $this->assertModelMissing($shot);
        Storage::disk('public')->assertMissing([$spot, $shot->path]);
    }

    public function test_validation_rejects_bad_icons_duplicate_slugs_and_self_relations(): void
    {
        $taken = Feature::factory()->create(['slug' => 'taken']);
        $feature = Feature::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.features.store'), ['title' => 'X', 'slug' => 'taken', 'icon' => 'not an icon', 'group' => 'other'])
            ->assertSessionHasErrors(['slug', 'icon', 'group']);

        $this->put(route('admin.features.update', $feature), [
            'title' => $feature->title, 'icon' => 'fa-check', 'group' => 'suite', 'related' => [$feature->id, $taken->id],
        ])->assertSessionHasErrors('related.0');
    }

    public function test_feature_permissions_are_enforced(): void
    {
        $feature = Feature::factory()->create();
        $this->actingAs($this->userWithRole('author'));

        $this->get(route('admin.features.index'))->assertForbidden();
        $this->get(route('admin.features.create'))->assertForbidden();
        $this->delete(route('admin.features.destroy', $feature))->assertForbidden();
    }
}
