<?php

namespace Tests\Feature;

use App\Models\DocGroup;
use App\Models\DocPage;
use App\Models\DocTask;
use App\Models\User;
use Database\Seeders\DocSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDocsTest extends TestCase
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

    /**
     * A valid page form submission with two standard sections.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function pagePayload(DocGroup $group, array $overrides = []): array
    {
        return [
            'doc_group_id' => $group->id,
            'slug' => 'loyalty-points',
            'number' => '14',
            'icon' => 'fa-star',
            'title' => 'Loyalty Points',
            'description' => 'Reward repeat customers with points they can spend at the till.',
            'intro' => '<p>Points build up with every sale.</p>',
            'is_active' => '1',
            'sort_order' => 1,
            'sections' => [
                ['heading' => 'Turning points on', 'anchor' => '', 'body' => '<p>Open Settings.</p>', 'is_custom' => '0'],
                ['heading' => 'Spending points', 'anchor' => 'spending', 'body' => '<div class="callout tip"><div class="callout-body">Tip</div></div>', 'heading_si' => 'ලකුණු භාවිතය', 'is_custom' => '0'],
            ],
            ...$overrides,
        ];
    }

    public function test_admin_docs_pages_render(): void
    {
        $this->seed(DocSeeder::class);
        $this->actingAs($this->userWithRole('editor'));
        $page = DocPage::firstWhere('slug', 'point-of-sale');

        $this->get(route('admin.docs.pages.index'))->assertOk()->assertSee('Point of Sale');
        $this->get(route('admin.docs.pages.create'))->assertOk();
        $this->get(route('admin.docs.pages.edit', $page))->assertOk()->assertSee('starting-a-sale')->assertSee('doc-steps');
        $this->get(route('admin.docs.groups.index'))->assertOk()->assertSee('Selling &amp; stock', false);
        $this->get(route('admin.docs.groups.edit', $page->group))->assertOk();
        $this->get(route('admin.docs.tasks.index'))->assertOk()->assertSee('Make a sale');
        $this->get(route('admin.docs.tasks.create'))->assertOk();
        $this->get(route('admin.docs.tasks.edit', DocTask::first()))->assertOk();
        $this->get(route('admin.dashboard'))->assertOk()->assertSee(route('admin.docs.pages.index'));
    }

    public function test_saving_an_imported_page_unchanged_keeps_its_content(): void
    {
        $this->seed(DocSeeder::class);
        $this->actingAs($this->userWithRole('editor'));

        foreach (DocPage::with('sections')->get() as $page) {
            $before = view('frontend.docs.partials.body', ['page' => $page])->render();

            $this->put(route('admin.docs.pages.update', $page), [
                ...$page->only(['doc_group_id', 'number', 'icon', 'title', 'title_si', 'description', 'description_si', 'intro', 'intro_si', 'outro', 'outro_si', 'sort_order']),
                'is_active' => '1',
                'sections' => $page->sections->map(fn ($section) => [
                    ...$section->only(['anchor', 'heading', 'heading_si', 'body', 'body_si']),
                    'is_custom' => $section->is_custom ? '1' : '0',
                ])->all(),
            ])->assertRedirect(route('admin.docs.pages.index'));

            $page->refresh()->load('sections');
            $this->assertSame($before, view('frontend.docs.partials.body', ['page' => $page])->render(), $page->slug);
        }
    }

    public function test_author_cannot_manage_docs(): void
    {
        $this->actingAs($this->userWithRole('author'));

        $this->get(route('admin.docs.pages.index'))->assertForbidden();
        $this->post(route('admin.docs.pages.store'), $this->pagePayload(DocGroup::factory()->create()))->assertForbidden();
        $this->post(route('admin.docs.images.store'), ['image' => UploadedFile::fake()->image('a.png')])->assertForbidden();
        $this->get(route('admin.dashboard'))->assertOk()->assertDontSee(route('admin.docs.pages.index'));
    }

    public function test_editor_creates_a_page_that_shows_on_the_docs(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $group = DocGroup::factory()->create(['name' => 'Customers']);

        $this->post(route('admin.docs.pages.store'), $this->pagePayload($group))
            ->assertRedirect(route('admin.docs.pages.index'));

        $page = DocPage::firstWhere('slug', 'loyalty-points');
        $this->assertSame(['turning-points-on', 'spending'], $page->sections->pluck('anchor')->all());

        $this->get(route('docs.index'))->assertOk()->assertSee('Customers')->assertSee('Loyalty Points');
        $this->get(route('docs.show', 'loyalty-points'))
            ->assertOk()
            ->assertSee('<p>Points build up with every sale.</p>', false)
            ->assertSee('<h3 id="turning-points-on">Turning points on</h3>', false)
            ->assertSee('href="#spending"', false)
            ->assertSee('callout tip', false);
    }

    public function test_updating_reorders_sections_cleans_scripts_and_keeps_the_address(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $page = DocPage::factory()->withSections('first', 'second')->create(['slug' => 'kept-address']);

        $this->put(route('admin.docs.pages.update', $page), $this->pagePayload($page->group, [
            'slug' => null,
            'sections' => [
                ['heading' => 'Second', 'anchor' => 'second', 'body' => '<p onclick="steal()">Hi</p><script>alert(1)</script><a href="javascript:alert(1)">x</a>', 'is_custom' => '0'],
                ['heading' => 'First', 'anchor' => 'first', 'body' => '<p>One</p>', 'is_custom' => '0'],
            ],
        ]))->assertRedirect(route('admin.docs.pages.index'));

        $page->refresh();
        $this->assertSame('kept-address', $page->slug);
        $this->assertSame(['second', 'first'], $page->sections->pluck('anchor')->all());
        $this->assertSame('<p>Hi</p><a href="#">x</a>', $page->sections->first()->body);
    }

    public function test_the_address_cannot_be_changed_after_creation(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $page = DocPage::factory()->withSections('only')->create();

        $this->put(route('admin.docs.pages.update', $page), $this->pagePayload($page->group, ['slug' => 'new-address']))
            ->assertSessionHasErrors('slug');
    }

    public function test_page_validation(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $group = DocGroup::factory()->create();

        $this->post(route('admin.docs.pages.store'), $this->pagePayload($group, ['slug' => 'api']))->assertSessionHasErrors('slug');
        $this->post(route('admin.docs.pages.store'), $this->pagePayload($group, ['sections' => []]))->assertSessionHasErrors('sections');
        $this->post(route('admin.docs.pages.store'), $this->pagePayload($group, ['sections' => [
            ['heading' => 'Same', 'anchor' => 'same', 'is_custom' => '0'],
            ['heading' => 'Same again', 'anchor' => 'same', 'is_custom' => '0'],
        ]]))->assertSessionHasErrors('sections.1.anchor');
        $this->post(route('admin.docs.pages.store'), $this->pagePayload($group, ['sections' => [
            ['heading' => 'Custom', 'anchor' => 'custom', 'body' => '<div class="chapter">no id</div>', 'is_custom' => '1'],
        ]]))->assertSessionHasErrors('sections.0.body');

        $this->assertSame(0, DocPage::count());
    }

    public function test_a_section_used_by_a_common_task_cannot_be_removed(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $page = DocPage::factory()->withSections('keep', 'linked')->create();
        DocTask::factory()->for($page, 'page')->create(['anchor' => 'linked', 'title' => 'Do the linked thing']);

        $this->put(route('admin.docs.pages.update', $page), $this->pagePayload($page->group, [
            'slug' => null,
            'sections' => [['heading' => 'Keep', 'anchor' => 'keep', 'is_custom' => '0']],
        ]))->assertSessionHasErrors('sections');

        $this->assertSame(['keep', 'linked'], $page->fresh()->sections->pluck('anchor')->all());
    }

    public function test_pages_and_groups_still_in_use_cannot_be_deleted(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $page = DocPage::factory()->withSections('linked')->create();
        DocTask::factory()->for($page, 'page')->create(['anchor' => 'linked']);

        $this->delete(route('admin.docs.pages.destroy', $page))->assertSessionHasErrors('delete');
        $this->delete(route('admin.docs.groups.destroy', $page->group))->assertSessionHasErrors('delete');
        $this->assertModelExists($page);

        $empty = DocGroup::factory()->create();
        $this->delete(route('admin.docs.groups.destroy', $empty))->assertRedirect(route('admin.docs.groups.index'));
        $this->assertModelMissing($empty);
    }

    public function test_editor_manages_groups_and_tasks(): void
    {
        $this->actingAs($this->userWithRole('editor'));
        $page = DocPage::factory()->withSections('closing-the-day')->create(['title' => 'Daily close']);

        $this->post(route('admin.docs.groups.store'), ['name' => 'Getting paid', 'name_si' => 'ගෙවීම්'])
            ->assertRedirect(route('admin.docs.groups.index'));
        $this->assertSame('getting-paid', DocGroup::firstWhere('name', 'Getting paid')->key);

        $this->post(route('admin.docs.tasks.store'), ['doc_page_id' => $page->id, 'anchor' => 'nowhere', 'icon' => 'fa-moon', 'title' => 'Close the day'])
            ->assertSessionHasErrors('anchor');
        $this->post(route('admin.docs.tasks.store'), ['doc_page_id' => $page->id, 'anchor' => 'closing-the-day', 'icon' => 'fa-moon', 'title' => 'Close the day'])
            ->assertRedirect(route('admin.docs.tasks.index'));

        $this->get(route('docs.index'))->assertOk()
            ->assertSee(route('docs.show', $page->slug).'#closing-the-day', false)
            ->assertSee('Close the day');
    }

    public function test_screenshot_upload_returns_a_site_relative_url(): void
    {
        Storage::fake('public');
        $this->actingAs($this->userWithRole('editor'));

        $url = $this->postJson(route('admin.docs.images.store'), ['image' => UploadedFile::fake()->image('till.png', 800, 500)])
            ->assertOk()
            ->json('url');

        $this->assertStringStartsWith('/storage/docs/', $url);
        Storage::disk('public')->assertExists(substr($url, strlen('/storage/')));

        $this->postJson(route('admin.docs.images.store'), ['image' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf')])
            ->assertUnprocessable();
    }
}
