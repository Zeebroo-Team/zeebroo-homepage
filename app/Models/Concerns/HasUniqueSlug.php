<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Fills the `slug` column from the model's source column (name or title) when it is left empty,
 * normalises a custom slug when one is given, and keeps it unique by appending -2, -3, ...
 */
trait HasUniqueSlug
{
    /**
     * The column the slug is generated from.
     */
    abstract protected function slugSource(): string;

    protected static function bootHasUniqueSlug(): void
    {
        static::saving(function (self $model): void {
            $base = Str::slug($model->slug ?: $model->{$model->slugSource()});
            $model->slug = $model->uniqueSlug($base !== '' ? $base : Str::lower(Str::random(8)));
        });
    }

    protected function uniqueSlug(string $base): string
    {
        $slug = $base;
        $suffix = 2;

        while (static::query()->where('slug', $slug)->whereKeyNot($this->getKey())->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
