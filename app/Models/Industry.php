<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\IndustryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * One industry page (/industries/{slug}). Drives the Industries mega menu,
 * the home page industries grid and the /industries index.
 *
 * @property list<array{icon: string, title: string, text: string}>|null $highlights
 * @property list<array{title: string, text: string}>|null $highlights_si Sinhala text of the highlight at the same index
 * @property list<string>|null $capabilities
 * @property list<string>|null $capabilities_si
 */
#[Fillable([
    'title', 'title_si', 'slug', 'menu', 'menu_si', 'icon', 'badge', 'badge_si', 'headline', 'headline_si',
    'lead', 'lead_si', 'highlights', 'highlights_si', 'capabilities', 'capabilities_si', 'scene_path',
    'meta_title', 'meta_title_si', 'meta_description', 'meta_description_si', 'meta_keywords', 'meta_keywords_si',
    'sort_order', 'is_active',
])]
class Industry extends Model
{
    /** @use HasFactory<IndustryFactory> */
    use HasFactory, HasTranslations, HasUniqueSlug;

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
     * Active industries in menu order, for the header, home page and /industries.
     *
     * @return Collection<int, self>
     */
    public static function navigation(): Collection
    {
        return static::active()->ordered()->get();
    }

    /**
     * Modules listed under "Modules for ..." on this industry's page.
     *
     * @return BelongsToMany<Feature, $this>
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class)
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
     * Public URL of the wide scene illustration, or null when none is uploaded.
     */
    protected function sceneUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->scene_path ? Storage::disk('public')->url($this->scene_path) : null);
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
