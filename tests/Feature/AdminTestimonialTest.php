<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTestimonialTest extends TestCase
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

    public function test_admin_testimonial_pages_render(): void
    {
        $testimonial = Testimonial::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.testimonials.index'))->assertOk()->assertSee($testimonial->name);
        $this->get(route('admin.testimonials.index', ['q' => $testimonial->name]))->assertOk()->assertSee($testimonial->name);
        $this->get(route('admin.testimonials.create'))->assertOk();
        $this->get(route('admin.testimonials.edit', $testimonial))->assertOk()->assertSee($testimonial->message);
    }

    public function test_editor_can_create_a_featured_testimonial_with_photo(): void
    {
        Storage::fake('public');
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.testimonials.store'), [
            'name' => 'Nimal Perera',
            'position' => 'Owner, Corner Café',
            'message' => 'Closing the till takes two minutes now.',
            'rating' => 4,
            'image' => UploadedFile::fake()->image('nimal.jpg'),
            'is_featured' => '1',
            'is_active' => '1',
            'sort_order' => 3,
        ])->assertRedirect(route('admin.testimonials.index'));

        $testimonial = Testimonial::firstWhere('name', 'Nimal Perera');
        $this->assertSame(4, $testimonial->rating);
        $this->assertSame(3, $testimonial->sort_order);
        $this->assertTrue($testimonial->is_featured);
        Storage::disk('public')->assertExists($testimonial->image_path);

        $this->get(route('home'))->assertOk()->assertSee('Closing the till takes two minutes now.')->assertSee($testimonial->image_url);
    }

    public function test_update_replaces_photo_and_remove_image_clears_it(): void
    {
        Storage::fake('public');
        $oldImage = UploadedFile::fake()->image('old.png')->store('testimonials', 'public');
        $testimonial = Testimonial::factory()->featured()->create(['image_path' => $oldImage]);
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.testimonials.update', $testimonial), [
            'name' => 'Renamed Customer',
            'message' => $testimonial->message,
            'image' => UploadedFile::fake()->image('new.png'),
            'is_active' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));

        $testimonial->refresh();
        $this->assertSame('Renamed Customer', $testimonial->name);
        $this->assertSame(Testimonial::MAX_RATING, $testimonial->rating);
        $this->assertFalse($testimonial->is_featured);
        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($newImage = $testimonial->image_path);

        $this->put(route('admin.testimonials.update', $testimonial), [
            'name' => $testimonial->name,
            'message' => $testimonial->message,
            'remove_image' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));

        $this->assertNull($testimonial->fresh()->image_path);
        Storage::disk('public')->assertMissing($newImage);
    }

    public function test_testimonial_stores_sinhala_content(): void
    {
        $testimonial = Testimonial::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.testimonials.update', $testimonial), [
            'name' => 'Nuwan Perera',
            'name_si' => 'නුවන් පෙරේරා',
            'position' => 'Owner, Perera Hardware',
            'position_si' => 'හිමිකරු, පෙරේරා හාඩ්වෙයාර්',
            'message' => 'Stock counts are finally right.',
            'message_si' => 'තොග ගණන් දැන් නිවැරදියි.',
            'is_active' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));

        $testimonial->refresh();
        $this->assertSame('නුවන් පෙරේරා', $testimonial->name_si);
        $this->assertSame('හිමිකරු, පෙරේරා හාඩ්වෙයාර්', $testimonial->position_si);
        $this->assertSame('තොග ගණන් දැන් නිවැරදියි.', $testimonial->message_si);

        $this->get(route('admin.testimonials.edit', $testimonial))->assertOk()
            ->assertSee('නුවන් පෙරේරා')
            ->assertSee('තොග ගණන් දැන් නිවැරදියි.');
    }

    public function test_deleting_a_testimonial_removes_its_photo(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('photo.png')->store('testimonials', 'public');
        $testimonial = Testimonial::factory()->create(['image_path' => $image]);
        $this->actingAs($this->userWithRole('editor'));

        $this->delete(route('admin.testimonials.destroy', $testimonial))->assertRedirect(route('admin.testimonials.index'));

        $this->assertModelMissing($testimonial);
        Storage::disk('public')->assertMissing($image);
    }

    public function test_testimonial_validation_rejects_bad_data(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.testimonials.store'), [
            'name' => '',
            'message' => '',
            'rating' => 6,
            'image' => UploadedFile::fake()->create('photo.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors(['name', 'message', 'rating', 'image']);

        $this->post(route('admin.testimonials.store'), ['name' => 'X', 'message' => 'Y', 'rating' => 0])
            ->assertSessionHasErrors('rating');
    }

    public function test_testimonial_permissions_are_enforced(): void
    {
        $testimonial = Testimonial::factory()->create();
        $this->actingAs($this->userWithRole('author'));

        $this->get(route('admin.testimonials.index'))->assertForbidden();
        $this->get(route('admin.testimonials.create'))->assertForbidden();
        $this->put(route('admin.testimonials.update', $testimonial), ['name' => 'X', 'message' => 'Y'])->assertForbidden();
        $this->delete(route('admin.testimonials.destroy', $testimonial))->assertForbidden();
    }
}
