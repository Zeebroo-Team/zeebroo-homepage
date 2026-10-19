<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_only_published_posts(): void
    {
        $published = Blog::factory()->create();
        $inactive = Blog::factory()->inactive()->create();
        $scheduled = Blog::factory()->scheduled()->create();
        $draft = Blog::factory()->draft()->create();

        $this->get(route('blog.index'))
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee($inactive->title)
            ->assertDontSee($scheduled->title)
            ->assertDontSee($draft->title);
    }

    public function test_show_renders_a_published_post_with_meta_tags(): void
    {
        $blog = Blog::factory()->create([
            'meta_title' => 'Custom SEO Title',
            'meta_description' => 'Custom SEO description',
            'meta_keywords' => 'pos, retail',
        ]);

        $this->get(route('blog.show', $blog->slug))
            ->assertOk()
            ->assertSee($blog->title)
            ->assertSee('<title>Custom SEO Title | Zeebroo Blog</title>', false)
            ->assertSee('content="Custom SEO description"', false)
            ->assertSee('content="pos, retail"', false);
    }

    public function test_unpublished_posts_return_404(): void
    {
        $this->get(route('blog.show', Blog::factory()->inactive()->create()->slug))->assertNotFound();
        $this->get(route('blog.show', Blog::factory()->scheduled()->create()->slug))->assertNotFound();
    }

    public function test_category_page_filters_posts_and_hides_inactive_categories(): void
    {
        $category = BlogCategory::factory()->create();
        $inCategory = Blog::factory()->for($category, 'category')->create();
        $other = Blog::factory()->create();

        $this->get(route('blog.category', $category->slug))
            ->assertOk()
            ->assertSee($inCategory->title)
            ->assertDontSee($other->title);

        $hidden = BlogCategory::factory()->inactive()->create();
        $this->get(route('blog.category', $hidden->slug))->assertNotFound();
    }

    public function test_tag_page_filters_posts(): void
    {
        $tag = BlogTag::factory()->create();
        $tagged = Blog::factory()->create();
        $tagged->tags()->attach($tag);
        $other = Blog::factory()->create();

        $this->get(route('blog.tag', $tag->slug))
            ->assertOk()
            ->assertSee($tagged->title)
            ->assertDontSee($other->title);
    }

    public function test_header_links_to_the_internal_blog(): void
    {
        $this->get(route('blog.index'))
            ->assertSee(route('blog.index'), false)
            ->assertDontSee('https://www.zeebroo.com/blog', false);
    }
}
