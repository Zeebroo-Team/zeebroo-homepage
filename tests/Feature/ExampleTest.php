<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_home_page_describes_the_organization_for_search_engines(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('{"@context":"https://schema.org","@type":"Organization"', false)
            ->assertSee('"logo":"'.asset('assets/logo.png').'"', false)
            ->assertSee('"sameAs":["https://www.linkedin.com/company/zeebroo/"]', false);
    }
}
