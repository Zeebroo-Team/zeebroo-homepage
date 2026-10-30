<?php

namespace App\Models\Concerns;

use App\Services\DocLibrary;

/**
 * Clears the cached docs (sidebar, pages, tasks) whenever a docs record is saved or deleted,
 * so /docs shows an admin's change on the next visit.
 */
trait FlushesDocLibrary
{
    protected static function bootFlushesDocLibrary(): void
    {
        static::saved(fn () => DocLibrary::flush());
        static::deleted(fn () => DocLibrary::flush());
    }
}
