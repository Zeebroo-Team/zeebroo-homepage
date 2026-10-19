<?php

namespace App\Models;

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
 * @property list<string>|null $capabilities
 */
#[Fillable([
    'title', 'slug', 'menu', 'icon', 'badge', 'headline', 'lead', 'highlights', 'capabilities',
    'scene_path', 'meta_title', 'meta_description', 'meta_keywords', 'sort_order', 'is_active',
])]
class Industry extends Model
{
    /** @use HasFactory<IndustryFactory> */
    use HasFactory, HasUniqueSlug;

    protected function slugSource(): string
    {
        return 'title';
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
            'capabilities' => 'array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
