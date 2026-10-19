<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Database\Seeders\BlogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_replaces_existing_blog_data_with_starter_content(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('blogs/old.jpg', 'old');
        $old = Blog::factory()->create();
        $oldCategory = $old->category;

        $this->seed(BlogSeeder::class);

        $this->assertModelMissing($old);
        $this->assertModelMissing($oldCategory);
        Storage::disk('public')->assertMissing('blogs/old.jpg');

        $this->assertSame(7, BlogCategory::count());
        $this->assertSame(18, BlogTag::count());
        $this->assertSame(11, Blog::published()->count());
        $this->assertTrue(Blog::whereDoesntHave('tags')->doesntExist());

        Blog::whereNotNull('image_path')->pluck('image_path')
            ->each(fn (string $path) => Storage::disk('public')->assertExists($path));
    }

    public function test_seeded_posts_render_on_the_blog(): void
    {
        Storage::fake('public');
        $this->seed(BlogSeeder::class);

        $this->get(route('blog.index'))->assertOk()->assertSee('Introducing the Zeebroo AI Agent');
        $this->get(route('blog.category', 'guides-tutorials'))->assertOk()->assertSee('Setting up Zeebroo for your restaurant');
        $this->get(route('blog.tag', 'restaurant'))->assertOk();
        $this->get(route('blog.show', 'how-to-set-reorder-levels'))->assertOk()->assertSee('Reorder level =', false);
    }

    public function test_running_it_twice_does_not_duplicate_content(): void
    {
        Storage::fake('public');

        $this->seed(BlogSeeder::class);
        $this->seed(BlogSeeder::class);

        $this->assertSame(11, Blog::count());
        $this->assertTrue(Blog::where('slug', 'like', '%-2')->doesntExist());
    }
}
