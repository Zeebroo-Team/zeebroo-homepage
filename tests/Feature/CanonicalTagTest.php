<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use App\Models\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CanonicalTagTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(['*' => Http::response(['data' => []])]);
    }

    public function test_home_page_has_exactly_one_canonical_with_a_trailing_slash(): void
    {
        $this->assertSame([route('home').'/'], $this->canonicals($this->get('/')));
    }

    /**
     * @return array<string, array{string}>
     */
    public static function publicPages(): array
    {
        return [
            'features' => ['/features'],
            'packages' => ['/packages'],
            'industries' => ['/industries'],
            'partners' => ['/partners'],
            'testimonials' => ['/testimonials'],
            'blog' => ['/blog'],
            'docs' => ['/docs'],
            'about' => ['/about'],
            'contact' => ['/contact'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_public_page_has_exactly_one_self_referencing_canonical(string $path): void
    {
        $this->assertSame([url($path)], $this->canonicals($this->get($path)));
    }

    public function test_query_parameters_are_left_out_of_the_canonical(): void
    {
        $this->assertSame([url('/features')], $this->canonicals($this->get('/features?utm_source=facebook&ref=ad#top')));
        $this->assertSame([url('/packages')], $this->canonicals($this->get('/packages?page=2')));
    }

    public function test_no_page_canonicalizes_to_the_home_page(): void
    {
        $feature = Feature::factory()->create();

        foreach ([...array_column(self::publicPages(), 0), '/features/'.$feature->slug] as $path) {
            $canonicals = $this->canonicals($this->get($path));

            $this->assertNotContains(route('home').'/', $canonicals, "{$path} points to the home page");
            $this->assertNotContains(route('home'), $canonicals, "{$path} points to the home page");
        }
    }

    public function test_english_and_sinhala_pos_pages_each_canonicalize_to_themselves(): void
    {
        Feature::factory()->create(['slug' => 'point-of-sale']);
        $english = route('features.show', 'point-of-sale');
        $sinhala = route('features.si', 'pos-system');

        $englishPage = $this->get($english);
        $this->assertSame([$english], $this->canonicals($englishPage));
        $englishPage->assertSee('<link rel="alternate" hreflang="si-LK" href="'.$sinhala.'">', false);

        $sinhalaPage = $this->get($sinhala);
        $this->assertSame([$sinhala], $this->canonicals($sinhalaPage));
        $sinhalaPage->assertSee('<link rel="alternate" hreflang="en-LK" href="'.$english.'">', false);
    }

    public function test_pages_shown_in_sinhala_keep_their_own_canonical(): void
    {
        $response = $this->withCookie(SetLocale::COOKIE, 'si')->get('/about');

        $response->assertSee('<html lang="si-LK">', false);
        $this->assertSame([url('/about')], $this->canonicals($response));
    }

    /**
     * Every canonical href on the page, in order.
     *
     * @return list<string>
     */
    private function canonicals(TestResponse $response): array
    {
        $response->assertOk();
        preg_match_all('/<link rel="canonical" href="([^"]*)">/', (string) $response->getContent(), $matches);

        return array_map(fn (string $href) => html_entity_decode($href), $matches[1]);
    }
}
