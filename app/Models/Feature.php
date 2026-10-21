<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\FeatureFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * One module page (/features/{slug}). Drives the header mega menu, the /features index,
 * the home page module switcher and the modules listed on industry and pricing pages.
 *
 * @property list<array{icon: string, title: string, text: string}>|null $highlights
 * @property list<array{title: string, text: string}>|null $highlights_si Sinhala text of the highlight at the same index
 * @property list<string>|null $capabilities
 * @property list<string>|null $capabilities_si
 */
#[Fillable([
    'title', 'title_si', 'slug', 'menu', 'menu_si', 'icon', 'group', 'badge', 'badge_si', 'headline', 'headline_si',
    'lead', 'lead_si', 'highlights', 'highlights_si', 'capabilities', 'capabilities_si', 'spot_path', 'scene_path',
    'meta_title', 'meta_title_si', 'meta_description', 'meta_description_si', 'meta_keywords', 'meta_keywords_si',
    'sort_order', 'is_active',
])]
class Feature extends Model
{
    /** @use HasFactory<FeatureFactory> */
    use HasFactory, HasTranslations, HasUniqueSlug;

    /**
     * Groups a feature can belong to: core = the headline modules with big cards, suite = "all included, plus".
     *
     * @var array<string, string>
     */
    public const GROUPS = [
        'core' => 'Core module',
        'suite' => 'All included, plus',
    ];

    protected function slugSource(): string
    {
        return 'title';
    }

    protected function translatableAttributes(): array
    {
        return [
            'title', 'menu', 'badge', 'headline', 'lead', 'highlights', 'capabilities',
            'meta_title', 'meta_description', 'meta_keywords',
        ];
    }

    /**
     * Active features in menu order, for the header, footer and home page.
     *
     * @return Collection<int, self>
     */
    public static function navigation(): Collection
    {
        return static::active()->ordered()->get();
    }

    /**
     * @return HasMany<FeatureScreenshot, $this>
     */
    public function screenshots(): HasMany
    {
        return $this->hasMany(FeatureScreenshot::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Modules shown under "Better together" on this feature's page.
     *
     * @return BelongsToMany<Feature, $this>
     */
    public function related(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'feature_related', 'feature_id', 'related_id')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Public URL of the square preview illustration, or null when none is uploaded.
     */
    protected function spotUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->spot_path ? Storage::disk('public')->url($this->spot_path) : null);
    }

    /**
     * Public URL of the wide scene illustration, or null when none is uploaded.
     */
    protected function sceneUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->scene_path ? Storage::disk('public')->url($this->scene_path) : null);
    }

    /**
     * Every file this feature owns on the public disk.
     *
     * @return list<string>
     */
    public function storedFiles(): array
    {
        return array_values(array_filter([
            $this->spot_path,
            $this->scene_path,
            ...$this->screenshots->pluck('path')->all(),
        ]));
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'highlights_si' => 'array',
            'capabilities' => 'array',
            'capabilities_si' => 'array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
