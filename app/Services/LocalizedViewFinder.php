<?php

namespace App\Services;

use Illuminate\View\FileViewFinder;
use InvalidArgumentException;

/**
 * Picks a view's language copy when one exists: with the website in Sinhala,
 * `frontend.home.hero` renders `frontend/home/hero_si.blade.php`, and falls back
 * to `hero.blade.php` (English) when there is no `_si` file yet.
 * Works for @include, @extends and view() alike, so templates never name the copy.
 */
class LocalizedViewFinder extends FileViewFinder
{
    /**
     * @param  string  $name
     */
    public function find($name): string
    {
        $locale = app()->getLocale();

        if ($locale !== config('app.fallback_locale') && ! str_contains($name, '::')) {
            try {
                return parent::find("{$name}_{$locale}");
            } catch (InvalidArgumentException) {
                // no translated copy of this view: use the English one
            }
        }

        return parent::find($name);
    }
}
