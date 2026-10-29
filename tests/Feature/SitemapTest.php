<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Feature;
use App\Models\Industry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_lists_public_pages_at_their_canonical_addresses(): void
    {
        Http::fake(['*/api/v1/pos/auth/packages' => Http::response(['data' => [
            ['slug' => 'growth', 'name' => 'Growth', 'description' => '', 'price' => 5000, 'discounted_price' => null, 'currency_symbol' => 'Rs ', 'features' => []],
        ]])]);
        Feature::factory()->create(['slug' => 'point-of-sale']);
        $hiddenFeature = Feature::factory()->inactive()->create();
        $industry = Industry::factory()->create();
        $post = Blog::factory()->create();
        $draft = Blog::factory()->draft()->create();

        $response = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = simplexml_load_string((string) $response->getContent());
        $this->assertNotFalse($xml, 'sitemap is not valid XML');
        $locs = array_map(fn ($url) => (string) $url->loc, iterator_to_array($xml->url, false));

        foreach ([
            route('home').'/',
            route('features.index'),
            route('features.show', 'point-of-sale'),
            route('features.si', 'pos-system'),
            route('industries.show', $industry->slug),
            route('packages.index'),
            route('packages.show', 'growth'),
            route('blog.show', $post->slug),
            route('docs.index'),
            route('about'),
            route('contact'),
        ] as $expected) {
            $this->assertContains($expected, $locs);
        }

        $this->assertNotContains(route('features.show', $hiddenFeature->slug), $locs);
        $this->assertNotContains(route('blog.show', $draft->slug), $locs);
        $this->assertSame($locs, array_values(array_unique($locs)), 'sitemap lists an address twice');
    }
}
