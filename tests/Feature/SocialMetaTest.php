<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SocialMetaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(['*' => Http::response(['data' => []])]);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function pagesWithTheDefaultImage(): array
    {
        return [
            'home' => ['/', 'Zeebroo: the POS that runs your whole business'],
            'about' => ['/about', 'About Us | Zeebroo'],
            'contact' => ['/contact', 'Contact Zeebroo: talk to our team'],
            'partners' => ['/partners', 'Partners &amp; clients | Zeebroo'],
            'testimonials' => ['/testimonials', 'Testimonials | Zeebroo'],
            'blog' => ['/blog', 'Blog | Zeebroo: news, tips and updates'],
        ];
    }

    #[DataProvider('pagesWithTheDefaultImage')]
    public function test_page_shares_the_default_image_with_its_own_title(string $path, string $title): void
    {
        $response = $this->get($path);
        $image = asset('assets/apple-touch-icon.png');

        $response->assertOk()
            ->assertSee('<meta property="og:title" content="'.$title.'">', false)
            ->assertSee('<meta property="og:image" content="'.$image.'">', false)
            ->assertSee('<meta property="og:image:width" content="180">', false)
            ->assertSee('<meta property="og:image:height" content="180">', false)
            ->assertSee('<meta property="og:locale" content="en_LK">', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<meta name="twitter:image" content="'.$image.'">', false);

        $this->assertSame(1, substr_count((string) $response->getContent(), 'property="og:image"'));
    }

    public function test_home_page_shares_its_canonical_url(): void
    {
        $this->get('/')->assertSee('<meta property="og:url" content="'.route('home').'/">', false);
    }

    #[DataProvider('pagesWithTheDefaultImage')]
    public function test_sinhala_page_shares_the_default_image_in_sinhala(string $path): void
    {
        $this->withCookie(SetLocale::COOKIE, 'si')->get($path)
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.asset('assets/apple-touch-icon.png').'">', false)
            ->assertSee('<meta property="og:locale" content="si_LK">', false);
    }

    public function test_blog_post_shares_its_featured_image(): void
    {
        $blog = Blog::factory()->create(['image_path' => 'blogs/cover.jpg']);
        $image = Storage::disk('public')->url('blogs/cover.jpg');

        $response = $this->get(route('blog.show', $blog->slug));

        $response->assertOk()
            ->assertSee('<meta property="og:image" content="'.$image.'">', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
            ->assertSee('<meta name="twitter:image" content="'.$image.'">', false);

        $this->assertSame(1, substr_count((string) $response->getContent(), 'property="og:image"'));
    }

    public function test_blog_post_without_an_image_shares_the_default_image(): void
    {
        $blog = Blog::factory()->create();
        $image = asset('assets/apple-touch-icon.png');

        $this->get(route('blog.show', $blog->slug))
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.$image.'">', false)
            ->assertSee('<meta name="twitter:card" content="summary">', false)
            ->assertSee('<meta name="twitter:image" content="'.$image.'">', false);
    }

    public function test_sinhala_blog_post_without_an_image_shares_the_default_image(): void
    {
        $blog = Blog::factory()->create();

        $this->withCookie(SetLocale::COOKIE, 'si')->get(route('blog.show', $blog->slug))
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.asset('assets/apple-touch-icon.png').'">', false)
            ->assertSee('<meta property="og:locale" content="si_LK">', false);
    }
}
