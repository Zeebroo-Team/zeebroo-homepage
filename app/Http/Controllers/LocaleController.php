<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
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

        return redirect()->to($target)->withCookie(cookie()->forever(SetLocale::COOKIE, $locale));
    }
}
