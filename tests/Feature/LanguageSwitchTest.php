<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use App\Models\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LanguageSwitchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake(['*' => Http::response(['data' => []])]);
    }

    public function test_switch_remembers_the_language_and_returns_to_the_previous_page(): void
    {
        $this->from(route('features.index'))
            ->get(route('locale.switch', 'si'))
            ->assertRedirect(route('features.index'))
            ->assertCookie(SetLocale::COOKIE, 'si');
    }

    public function test_switch_never_redirects_off_site(): void
    {
        $this->from('https://evil.example/phish')
            ->get(route('locale.switch', 'si'))
            ->assertRedirect(route('home'));
    }

    public function test_switch_rejects_unknown_languages(): void
    {
        $this->get(route('locale.switch', 'fr'))->assertNotFound();
    }

    public function test_home_page_is_english_by_default(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('Grow your business')
            ->assertDontSee('සියල්ල එකම ඇප් එකකින් පාලනය කරන්න');
    }

    public function test_sinhala_visitors_get_the_si_views_and_sinhala_database_content(): void
    {
        Feature::factory()->core()->create(['title' => 'Stock Control', 'title_si' => 'තොග පාලනය']);

        $this->withCookie(SetLocale::COOKIE, 'si')
            ->get(route('home'))
            ->assertOk()
            ->assertSee('<html lang="si">', false)
            ->assertSee('සියල්ල එකම ඇප් එකකින් පාලනය කරන්න')
            ->assertSee('ඔබේ ව්‍යාපාරයට අවශ්‍ය සියල්ල එකම තැනක')
            ->assertSee('තොග පාලනය')
            ->assertDontSee('Grow your business');
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function sinhalaPages(): array
    {
        return [
            'features' => ['features.index', 'සියලුම <span class="mark">මොඩියුල.</span>', 'One platform, every'],
            'industries' => ['industries.index', 'සියලුම ක්ෂේත්‍ර', 'All industries'],
            'pricing' => ['packages.index', 'මිල ගණන් මේ මොහොතේ සෙමින් පූරණය වේ', 'Pricing is loading slowly'],
            'partners' => ['partners.index', 'Zeebroo හවුල්කරුවෙකු වන්න', 'Become a Zeebroo partner'],
            'testimonials' => ['testimonials.index', 'ඔබේම කතාව ලිවීමට සූදානම්ද?', 'Ready to write your own story?'],
            'blog' => ['blog.index', 'තවම මෙහි ලිපි නැත', 'here yet'],
            'about' => ['about', 'අප කටයුතු කරන මූලධර්ම හය.', 'Six promises behind every screen.'],
            'contact' => ['contact', 'පණිවිඩය යවන්න', 'Send message'],
        ];
    }

    #[DataProvider('sinhalaPages')]
    public function test_every_page_has_a_sinhala_version(string $route, string $sinhala, string $english): void
    {
        $this->get(route($route))->assertOk()->assertSee($english, false);

        $this->withCookie(SetLocale::COOKIE, 'si')
            ->get(route($route))
            ->assertOk()
            ->assertSee($sinhala, false)
            ->assertDontSee($english, false);
    }

    public function test_feature_page_uses_sinhala_template_and_content(): void
    {
        $feature = Feature::factory()->create(['title' => 'Payroll', 'title_si' => 'වැටුප් ලේඛනය']);

        $this->withCookie(SetLocale::COOKIE, 'si')
            ->get(route('features.show', $feature->slug))
            ->assertOk()
            ->assertSee('වැටුප් ලේඛනය ඔබේ ව්‍යාපාරයට උපකාරී වන ආකාරය')
            ->assertDontSee('Book a demo');
    }

    public function test_contact_form_errors_are_in_sinhala(): void
    {
        $this->withCookie(SetLocale::COOKIE, 'si')
            ->from(route('contact'))
            ->post(route('contact.store'), ['topic' => 'demo'])
            ->assertSessionHasErrors(['name' => 'සම්පූර්ණ නම අවශ්‍යයි.']);
    }

    public function test_database_content_falls_back_to_english_when_sinhala_is_empty(): void
    {
        $feature = Feature::factory()->create([
            'title' => 'Payroll',
            'title_si' => null,
            'highlights' => [['icon' => 'fa-check', 'title' => 'Fast', 'text' => 'Runs in minutes']],
            'highlights_si' => [['title' => 'වේගවත්', 'text' => '']],
        ]);

        app()->setLocale('si');

        $this->assertSame('Payroll', $feature->title);
        $this->assertSame([['icon' => 'fa-check', 'title' => 'වේගවත්', 'text' => 'Runs in minutes']], $feature->highlights);
    }
}
