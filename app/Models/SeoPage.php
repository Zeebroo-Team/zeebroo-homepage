<?php

namespace App\Models;

use Database\Factories\SeoPageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Search and share settings for one fixed website page, edited in /admin/seo.
 * Every empty field leaves the page's own title, description or the site-wide
 * default share image (config/social.php) in place.
 */
#[Fillable([
    'key', 'meta_title', 'meta_title_si', 'meta_description', 'meta_description_si', 'og_image_path', 'og_image_alt', 'og_image_alt_si',
])]
class SeoPage extends Model
{
    /** @use HasFactory<SeoPageFactory> */
    use HasFactory;

    /**
     * Pages that can be edited, keyed by `key`, with the name and address shown in the admin.
     *
     * @var array<string, array{name: string, route: string}>
     */
    public const PAGES = [
        'home' => ['name' => 'Home page', 'route' => 'home'],
    ];

    /**
     * Width and height every uploaded share image is cropped to.
     */
    public const OG_IMAGE_WIDTH = 1200;

    public const OG_IMAGE_HEIGHT = 630;

    /**
     * Saved settings for a page, cached until the next save; null when nothing is saved.
     */
    public static function forPage(string $key): ?self
    {
        $attributes = Cache::rememberForever(
            self::cacheKey($key),
            fn (): array => self::firstWhere('key', $key)?->getAttributes() ?? [],
        );

        return $attributes === [] ? null : (new self)->newFromBuilder($attributes);
    }

    public static function cacheKey(string $key): string
    {
        return "seo_pages.v2.{$key}";
    }

    protected static function booted(): void
    {
        static::saved(fn (self $page) => Cache::forget(self::cacheKey($page->key)));
        static::deleted(fn (self $page) => Cache::forget(self::cacheKey($page->key)));
    }

    /**
     * The column's text in the website's current language, without falling back to English,
     * so a Sinhala page keeps its own Sinhala text until a Sinhala value is saved.
     */
    public function localized(string $column): ?string
    {
        $locale = app()->getLocale();
        $value = $locale === config('app.fallback_locale') ? $this->{$column} : $this->{"{$column}_{$locale}"};

        return filled($value) ? $value : null;
    }

    /**
     * Admin name of the page, e.g. "Home page".
     */
    protected function name(): Attribute
    {
        return Attribute::get(fn (): string => self::PAGES[$this->key]['name'] ?? $this->key);
    }

    /**
     * Public address of the page.
     */
    protected function url(): Attribute
    {
        return Attribute::get(fn (): ?string => isset(self::PAGES[$this->key]) ? route(self::PAGES[$this->key]['route']) : null);
    }

    /**
     * Public URL of the uploaded share image, or null when none is uploaded.
     */
    protected function ogImageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->og_image_path ? Storage::disk('public')->url($this->og_image_path) : null);
    }
}
