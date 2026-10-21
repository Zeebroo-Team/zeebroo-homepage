<?php

namespace App\Models\Concerns;

/**
 * Reads translated columns for the current locale: with the website in Sinhala, `$feature->title`
 * returns `title_si` and falls back to `title` when the Sinhala text is empty.
 * List columns (highlights, capabilities) are merged item by item, so a highlight keeps its icon
 * and any item left untranslated stays in English.
 */
trait HasTranslations
{
    /**
     * The English columns that have a `{column}_{locale}` translation.
     *
     * @return list<string>
     */
    abstract protected function translatableAttributes(): array;

    /**
     * @param  string  $key
     */
    public function getAttribute($key): mixed
    {
        $value = parent::getAttribute($key);
        $locale = app()->getLocale();

        if ($locale === config('app.fallback_locale') || ! in_array($key, $this->translatableAttributes(), true)) {
            return $value;
        }

        return $this->mergeTranslation($value, parent::getAttribute("{$key}_{$locale}"));
    }

    protected function mergeTranslation(mixed $original, mixed $translated): mixed
    {
        if (! is_array($original)) {
            return filled($translated) ? $translated : $original;
        }

        if (! is_array($translated) || $translated === []) {
            return $original;
        }

        return array_map(function (mixed $item, int|string $index) use ($translated): mixed {
            $translatedItem = $translated[$index] ?? null;

            if (is_array($item)) {
                return array_merge($item, array_filter(is_array($translatedItem) ? $translatedItem : [], 'filled'));
            }

            return filled($translatedItem) ? $translatedItem : $item;
        }, $original, array_keys($original));
    }
}
