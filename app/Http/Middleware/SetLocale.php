<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the website language the visitor picked with the language switch (kept in the `locale` cookie).
 * Only the public website uses it, so the admin panel always edits the English columns.
 */
class SetLocale
{
    /**
     * Name of the cookie that remembers the visitor's language.
     */
    public const COOKIE = 'locale';

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie(self::COOKIE);

        if (is_string($locale) && array_key_exists($locale, config('app.locales'))) {
            app()->setLocale($locale);
            Carbon::setLocale($locale);
        }

        return $next($request);
    }
}
