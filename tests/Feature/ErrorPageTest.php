<?php

namespace Tests\Feature;

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use RuntimeException;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_unknown_address_shows_the_branded_404_page(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('<html lang="en">', false)
            ->assertSee('This page went missing.')
            ->assertSee('<meta name="robots" content="noindex">', false)
            ->assertSee(route('home'))
            ->assertSee(route('contact'));
    }

    public function test_unknown_address_shows_the_404_page_in_sinhala(): void
    {
        $this->withCookie(SetLocale::COOKIE, 'si')
            ->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('<html lang="si">', false)
            ->assertSee('මෙම පිටුව සොයාගත නොහැක.')
            ->assertSee('මුල් පිටුවට')
            ->assertDontSee('This page went missing.');
    }

    public function test_missing_content_shows_the_404_page(): void
    {
        $this->get(route('blog.show', 'missing-post'))
            ->assertNotFound()
            ->assertSee('This page went missing.');
    }

    public function test_server_errors_show_the_500_page(): void
    {
        config(['app.debug' => false]);
        Route::get('/_test/boom', fn () => throw new RuntimeException('Boom'));

        $this->get('/_test/boom')
            ->assertInternalServerError()
            ->assertSee('Something broke on our side.')
            ->assertDontSee('Boom');
    }

    public function test_maintenance_shows_the_503_page(): void
    {
        Route::get('/_test/down', fn () => abort(503));

        $this->get('/_test/down')
            ->assertServiceUnavailable()
            ->assertSee('Back in a few minutes.');
    }

    public function test_other_client_errors_use_the_generic_4xx_page(): void
    {
        Route::get('/_test/teapot', fn () => abort(418));

        $this->get('/_test/teapot')
            ->assertStatus(418)
            ->assertSee('Something is not right.')
            ->assertSee('418');
    }
}
