<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_links_to_the_internal_docs(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('docs.index'))
            ->assertDontSee('https://www.zeebroo.com/tutorial');
    }

    public function test_old_tutorial_address_redirects_to_the_docs(): void
    {
        $this->get('/tutorial')->assertRedirect('/docs')->assertStatus(301);
    }

    public function test_docs_index_lists_every_page(): void
    {
        $response = $this->get(route('docs.index'))
            ->assertOk()
            ->assertSee('Learn Zeebroo, step by')
            ->assertSee(asset(config('docs.guide_pdf')));

        foreach (config('docs.pages') as $slug => $page) {
            $response->assertSee(route('docs.show', $slug))->assertSee($page['title']);
        }
    }

    public function test_every_docs_page_renders_its_chapter_and_section_anchors(): void
    {
        foreach (config('docs.pages') as $slug => $page) {
            $response = $this->get(route('docs.show', $slug))
                ->assertOk()
                ->assertSee($page['title'])
                ->assertSee(asset('assets/css/docs.css'));

            foreach (array_keys($page['sections']) as $anchor) {
                $response->assertSee('id="'.$anchor.'"', false)->assertSee('href="#'.$anchor.'"', false);
            }
        }
    }

    public function test_docs_page_links_to_its_neighbours(): void
    {
        $this->get(route('docs.show', 'getting-started'))
            ->assertOk()
            ->assertSee(route('docs.show', 'home-dashboard'))
            ->assertSee('Creating Your Account')
            ->assertSee(asset('assets/docs/onboarding/setup_your_account.png'));
    }

    public function test_unknown_docs_page_is_not_found(): void
    {
        $this->get(route('docs.show', 'no-such-chapter'))->assertNotFound();
        $this->get(route('docs.api.show', 'no-such-resource'))->assertNotFound();
    }

    public function test_header_and_guide_link_to_the_api_reference(): void
    {
        $this->get(route('home'))->assertOk()->assertSee(route('docs.api.index'));
        $this->get(route('docs.index'))->assertOk()->assertSee(route('docs.api.index'));
    }

    public function test_api_overview_lists_every_resource_and_the_conventions(): void
    {
        $response = $this->get(route('docs.api.index'))
            ->assertOk()
            ->assertSee('Build on the Zeebroo')
            ->assertSee('X-Business-Id', false);

        foreach (config('api-docs.groups') as $group) {
            $response->assertSee($group['title']);

            foreach (array_keys($group['resources']) as $slug) {
                $response->assertSee(route('docs.api.show', $slug));
            }
        }
    }

    public function test_every_api_resource_page_renders_all_its_endpoints(): void
    {
        $endpointCount = 0;

        foreach (config('api-docs.groups') as $group) {
            foreach ($group['resources'] as $slug => $resource) {
                $response = $this->get(route('docs.api.show', $slug))
                    ->assertOk()
                    ->assertSee($resource['title']);

                foreach ($resource['endpoints'] as $anchor => [$method, $path]) {
                    $response->assertSee('id="'.$anchor.'"', false)
                        ->assertSee('href="#'.$anchor.'"', false)
                        ->assertSee($path);
                    $endpointCount++;
                }
            }
        }

        $this->assertSame(config('api-docs.endpoint_count'), $endpointCount);
    }

    public function test_docs_index_links_every_common_task_to_a_real_section(): void
    {
        $response = $this->get(route('docs.index'))->assertOk()->assertSee('Common tasks');

        foreach (config('docs.tasks') as $task) {
            $this->assertArrayHasKey($task['anchor'], config("docs.pages.{$task['page']}.sections"));
            $response->assertSee(route('docs.show', $task['page']).'#'.$task['anchor'], false)->assertSee($task['title']);
        }
    }

    public function test_docs_page_shows_reading_time_and_help(): void
    {
        $this->get(route('docs.show', 'point-of-sale'))
            ->assertOk()
            ->assertSee('min read')
            ->assertSee('data-docs-print', false)
            ->assertSee(route('contact'));
    }

    public function test_every_docs_page_has_a_sinhala_copy_with_the_same_anchors(): void
    {
        foreach (config('docs.pages') as $slug => $page) {
            $this->assertSame(array_keys($page['sections']), array_keys($page['sections_si']), "{$slug} Sinhala sections");
            $this->assertFileExists(resource_path("views/frontend/docs/chapters/{$slug}_si.blade.php"));

            $response = $this->withCookie(SetLocale::COOKIE, 'si')
                ->get(route('docs.show', $slug))
                ->assertOk()
                ->assertSee($page['title_si'])
                ->assertSee('මිනිත්තු')
                ->assertDontSee($page['description']);

            foreach ($page['sections_si'] as $anchor => $heading) {
                $response->assertSee('id="'.$anchor.'"', false)->assertSee($heading);
            }
        }
    }

    public function test_sinhala_docs_index_lists_every_page_and_task_in_sinhala(): void
    {
        $response = $this->withCookie(SetLocale::COOKIE, 'si')
            ->get(route('docs.index'))
            ->assertOk()
            ->assertSee('නිතර කරන කාර්යයන්')
            ->assertDontSee('Common tasks');

        foreach (config('docs.groups_si') as $label) {
            $response->assertSee($label);
        }

        foreach (config('docs.pages') as $page) {
            $response->assertSee($page['title_si']);
        }

        foreach (config('docs.tasks') as $task) {
            $response->assertSee($task['title_si']);
        }
    }

    public function test_sinhala_api_reference_translates_groups_but_keeps_endpoints(): void
    {
        $response = $this->withCookie(SetLocale::COOKIE, 'si')
            ->get(route('docs.api.index'))
            ->assertOk()
            ->assertSee('X-Business-Id', false);

        foreach (config('api-docs.groups') as $group) {
            $response->assertSee($group['title_si'])->assertDontSee($group['description']);
        }

        $this->withCookie(SetLocale::COOKIE, 'si')
            ->get(route('docs.api.show', 'auth'))
            ->assertOk()
            ->assertSee(config('api-docs.groups.foundation.title_si'))
            ->assertSee('/api/v1/pos/auth/token');
    }

    public function test_api_code_samples_are_not_compiled_as_blade(): void
    {
        $this->get(route('docs.api.show', 'auth'))
            ->assertOk()
            ->assertSee('"access_token": "1|abcdef123456..."', false);
    }
}
