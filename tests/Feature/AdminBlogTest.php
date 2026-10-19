<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBlogTest extends TestCase
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

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get(route('admin.blog.posts.index'))->assertRedirect(route('admin.login'));
    }

    public function test_users_without_a_role_cannot_sign_in(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_sign_in(): void
    {
        $user = $this->userWithRole('editor');

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_pages_render(): void
    {
        $blog = Blog::factory()->create();
        $tag = BlogTag::factory()->create();
        $this->actingAs($this->userWithRole('super-admin'));

        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.blog.posts.index'))->assertOk()->assertSee($blog->title);
        $this->get(route('admin.blog.posts.create'))->assertOk();
        $this->get(route('admin.blog.posts.edit', $blog))->assertOk();
        $this->get(route('admin.blog.categories.index'))->assertOk()->assertSee($blog->category->name);
        $this->get(route('admin.blog.categories.create'))->assertOk();
        $this->get(route('admin.blog.categories.edit', $blog->category))->assertOk();
        $this->get(route('admin.blog.tags.index'))->assertOk()->assertSee($tag->name);
        $this->get(route('admin.blog.tags.create'))->assertOk();
        $this->get(route('admin.blog.tags.edit', $tag))->assertOk();
    }

    public function test_category_crud_with_auto_and_custom_slugs(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.blog.categories.store'), ['name' => 'Shop Tips', 'slug' => '', 'is_active' => '1'])
            ->assertRedirect(route('admin.blog.categories.index'));
        $category = BlogCategory::firstWhere('name', 'Shop Tips');
        $this->assertSame('shop-tips', $category->slug);

        $this->put(route('admin.blog.categories.update', $category), ['name' => 'Shop Tips', 'slug' => 'Custom Path', 'is_active' => '0'])
            ->assertRedirect();
        $this->assertSame('custom-path', $category->fresh()->slug);
        $this->assertFalse($category->fresh()->is_active);

        $this->delete(route('admin.blog.categories.destroy', $category))->assertRedirect();
        $this->assertModelMissing($category);
    }

    public function test_custom_slug_must_be_unique(): void
    {
        BlogTag::factory()->create(['slug' => 'taken']);
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.blog.tags.store'), ['name' => 'New', 'slug' => 'taken'])
            ->assertSessionHasErrors('slug');
    }

    public function test_editor_can_create_a_post_with_tags_and_image(): void
    {
        Storage::fake('public');
        $category = BlogCategory::factory()->create();
        $tags = BlogTag::factory(2)->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->post(route('admin.blog.posts.store'), [
            'title' => 'Launching Zeebroo POS',
            'meta_title' => 'Launch',
            'meta_description' => 'We launched',
            'meta_keywords' => 'pos, launch',
            'category_id' => $category->id,
            'tags' => $tags->pluck('id')->all(),
            'author_name' => 'Jane Doe',
            'published_at' => now()->subHour()->format('Y-m-d\TH:i'),
            'description' => '<p>Hello</p>',
            'image' => UploadedFile::fake()->image('cover.jpg'),
            'is_active' => '1',
        ])->assertRedirect(route('admin.blog.posts.index'));

        $blog = Blog::firstWhere('title', 'Launching Zeebroo POS');
        $this->assertSame('launching-zeebroo-pos', $blog->slug);
        $this->assertTrue($blog->is_active);
        $this->assertCount(2, $blog->tags);
        Storage::disk('public')->assertExists($blog->image_path);

        $this->get(route('blog.show', $blog->slug))->assertOk();
    }

    public function test_updating_a_post_can_replace_and_remove_the_image(): void
    {
        Storage::fake('public');
        $old = UploadedFile::fake()->image('old.jpg')->store('blogs', 'public');
        $blog = Blog::factory()->create(['image_path' => $old]);
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.blog.posts.update', $blog), [
            'title' => $blog->title, 'slug' => $blog->slug, 'is_active' => '1',
            'image' => UploadedFile::fake()->image('new.jpg'),
        ])->assertRedirect();
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($blog->fresh()->image_path);

        $this->put(route('admin.blog.posts.update', $blog), [
            'title' => $blog->title, 'slug' => $blog->slug, 'is_active' => '1', 'remove_image' => '1',
        ])->assertRedirect();
        $this->assertNull($blog->fresh()->image_path);
    }

    public function test_author_posts_stay_inactive_until_published_by_an_editor(): void
    {
        $this->actingAs($this->userWithRole('author'));

        $this->post(route('admin.blog.posts.store'), [
            'title' => 'Author Draft',
            'is_active' => '1',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ])->assertRedirect();

        $blog = Blog::firstWhere('title', 'Author Draft');
        $this->assertFalse($blog->is_active);
        $this->assertNull($blog->published_at);
    }

    public function test_permissions_are_enforced(): void
    {
        $blog = Blog::factory()->create();
        $tag = BlogTag::factory()->create();
        $this->actingAs($this->userWithRole('author'));

        $this->delete(route('admin.blog.posts.destroy', $blog))->assertForbidden();
        $this->get(route('admin.blog.tags.create'))->assertForbidden();
        $this->delete(route('admin.blog.tags.destroy', $tag))->assertForbidden();
        $this->get(route('admin.blog.posts.index'))->assertOk();
    }
}
