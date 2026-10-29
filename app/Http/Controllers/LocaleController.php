<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class LocaleController extends Controller
{
    // GET /lang/{locale} — remember the picked website language, then return to the page the visitor was on
    public function __invoke(string $locale): RedirectResponse
    {
        abort_unless(array_key_exists($locale, config('app.locales')), 404);

        // only ever bounce back to a page on this site
        $previous = url()->previous();
        $isOwnPage = $previous === url('/') || Str::startsWith($previous, url('/').'/');
        $target = $isOwnPage && ! Str::contains($previous, '/lang/') ? $previous : route('home');

        return redirect()->to($this->counterpart($target, $locale))->withCookie(cookie()->forever(SetLocale::COOKIE, $locale));
    }

    // a feature with its own Sinhala address swaps between /features/{slug} and /si/{path}, since /si/{path} is always Sinhala
    private function counterpart(string $url, string $locale): string
    {
        $page = Str::before(Str::before($url, '#'), '?');

        foreach (Feature::SINHALA_PATHS as $slug => $path) {
            if ($locale === 'si' && $page === route('features.show', $slug)) {
                return route('features.si', $path);
            }

            if ($locale !== 'si' && $page === route('features.si', $path)) {
                return route('features.show', $slug);
            }
        }

        return $url;
    }
}
