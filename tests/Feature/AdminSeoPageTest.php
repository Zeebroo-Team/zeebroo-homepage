<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use App\Models\SeoPage;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSeoPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        Http::fake(['*' => Http::response(['data' => []])]);
    }

    private function userWithRole(string $role): User
    {
        return User::factory()->create()->assignRole($role);
    }

    public function test_admin_seo_pages_render(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.seo.pages.index'))->assertOk()->assertSee('Home page');
        $this->get(route('admin.seo.pages.edit', 'home'))->assertOk()->assertSee('Share image');
        $this->get(route('admin.dashboard'))->assertOk()->assertSee(route('admin.seo.pages.index'));
    }

    public function test_unknown_page_is_not_found(): void
    {
        $this->actingAs($this->userWithRole('editor'));

        $this->get('/admin/seo/pages/nowhere/edit')->assertNotFound();
    }

    public function test_author_cannot_see_or_edit_seo(): void
    {
        $this->actingAs($this->userWithRole('author'));

        $this->get(route('admin.seo.pages.index'))->assertForbidden();
        $this->put(route('admin.seo.pages.update', 'home'), ['meta_title' => 'Hacked'])->assertForbidden();
        $this->get(route('admin.dashboard'))->assertOk()->assertDontSee(route('admin.seo.pages.index'));
        $this->assertNull(SeoPage::firstWhere('key', 'home'));
    }

    public function test_editor_saves_home_seo_and_the_image_is_cropped_to_1200_by_630(): void
    {
        Storage::fake('public');
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.seo.pages.update', 'home'), [
            'meta_title' => 'POS System Sri Lanka | Zeebroo',
            'meta_description' => 'Billing, stock and accounts in one place.',
            'og_image_alt' => 'Zeebroo POS on a laptop',
            'meta_title_si' => 'ශ්‍රී ලංකාව සඳහා POS පද්ධතිය',
            'image' => UploadedFile::fake()->image('cover.png', 1600, 1600),
        ])->assertRedirect(route('admin.seo.pages.index'));

        $page = SeoPage::firstWhere('key', 'home');
        $this->assertSame('POS System Sri Lanka | Zeebroo', $page->meta_title);
        $this->assertSame('ශ්‍රී ලංකාව සඳහා POS පද්ධතිය', $page->meta_title_si);
        $this->assertStringEndsWith('.jpg', $page->og_image_path);

        [$width, $height] = getimagesizefromstring(Storage::disk('public')->get($page->og_image_path));
        $this->assertSame([1200, 630], [$width, $height]);
    }

    public function test_replacing_and_removing_the_image_deletes_the_old_file(): void
    {
        Storage::fake('public');
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.seo.pages.update', 'home'), ['image' => UploadedFile::fake()->image('a.jpg', 1200, 630)]);
        $first = SeoPage::firstWhere('key', 'home')->og_image_path;

        $this->put(route('admin.seo.pages.update', 'home'), ['image' => UploadedFile::fake()->image('b.jpg', 2400, 900)]);
        $second = SeoPage::firstWhere('key', 'home')->og_image_path;
        Storage::disk('public')->assertMissing($first);
        Storage::disk('public')->assertExists($second);

        $this->put(route('admin.seo.pages.update', 'home'), ['remove_image' => '1']);
        Storage::disk('public')->assertMissing($second);
        $this->assertNull(SeoPage::firstWhere('key', 'home')->og_image_path);
    }

    public function test_image_must_be_a_large_enough_jpg_or_png(): void
    {
        Storage::fake('public');
        $this->actingAs($this->userWithRole('editor'));

        $this->put(route('admin.seo.pages.update', 'home'), ['image' => UploadedFile::fake()->image('tiny.jpg', 300, 200)])
            ->assertSessionHasErrors('image');
        $this->put(route('admin.seo.pages.update', 'home'), ['image' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf')])
            ->assertSessionHasErrors('image');
    }

    public function test_home_page_uses_the_saved_seo(): void
    {
        $page = SeoPage::factory()->withImage('seo/home.jpg')->create([
            'meta_title' => 'POS System Sri Lanka | Zeebroo',
            'meta_description' => 'Billing, stock and accounts in one place.',
            'og_image_alt' => 'Zeebroo POS on a laptop',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('<title>POS System Sri Lanka | Zeebroo</title>', false)
            ->assertSee('<meta name="description" content="Billing, stock and accounts in one place.">', false)
            ->assertSee('<meta property="og:title" content="POS System Sri Lanka | Zeebroo">', false)
            ->assertSee('<meta property="og:image" content="'.$page->og_image_url.'">', false)
            ->assertSee('<meta property="og:image:width" content="1200">', false)
            ->assertSee('<meta property="og:image:height" content="630">', false)
            ->assertSee('<meta property="og:image:alt" content="Zeebroo POS on a laptop">', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
    }

    public function test_home_page_keeps_its_defaults_when_nothing_is_saved(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<title>'.config('social.default.title').'</title>', false)
            ->assertSee('<meta property="og:image" content="'.asset('assets/apple-touch-icon.png').'">', false);
    }

    public function test_sinhala_home_page_keeps_its_sinhala_title_when_only_english_is_saved(): void
    {
        SeoPage::factory()->create(['meta_title' => 'English only title']);

        $this->withCookie(SetLocale::COOKIE, 'si')->get('/')
            ->assertOk()
            ->assertDontSee('English only title')
            ->assertSee('<title>Zeebroo: ඔබේ මුළු ව්‍යාපාරයම එකම තැනකින් පාලනය කරන POS පද්ධතිය</title>', false);
    }

    public function test_saving_clears_the_cached_settings(): void
    {
        $page = SeoPage::factory()->create(['meta_title' => 'First title']);
        $this->assertSame('First title', SeoPage::forPage('home')->meta_title);

        $page->update(['meta_title' => 'Second title']);

        $this->assertSame('Second title', SeoPage::forPage('home')->meta_title);
    }
}
