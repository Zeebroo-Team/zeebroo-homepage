<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_generated_from_name_or_title_when_empty(): void
    {
        $category = BlogCategory::create(['name' => 'Retail Tips & Tricks']);
        $tag = BlogTag::create(['name' => 'Point of Sale']);
        $blog = Blog::create(['title' => 'Hello World: Our First Post!']);

        $this->assertSame('retail-tips-tricks', $category->slug);
        $this->assertSame('point-of-sale', $tag->slug);
        $this->assertSame('hello-world-our-first-post', $blog->slug);
    }

    public function test_custom_slug_is_kept_and_normalised(): void
    {
        $blog = Blog::create(['title' => 'Anything', 'slug' => 'My Custom Slug']);

        $this->assertSame('my-custom-slug', $blog->slug);
    }

    public function test_duplicate_slugs_get_a_numeric_suffix(): void
    {
        Blog::create(['title' => 'Same Title']);
        $second = Blog::create(['title' => 'Same Title']);
        $third = Blog::create(['title' => 'Same Title']);

        $this->assertSame('same-title-2', $second->slug);
        $this->assertSame('same-title-3', $third->slug);
    }

    public function test_updating_without_changing_the_slug_keeps_it(): void
    {
        $blog = Blog::create(['title' => 'Original']);
        $blog->update(['title' => 'Renamed']);

        $this->assertSame('original', $blog->fresh()->slug);
    }

    public function test_clearing_the_slug_regenerates_it_from_the_title(): void
    {
        $blog = Blog::create(['title' => 'Original']);
        $blog->update(['title' => 'Renamed', 'slug' => null]);

        $this->assertSame('renamed', $blog->fresh()->slug);
    }
}
