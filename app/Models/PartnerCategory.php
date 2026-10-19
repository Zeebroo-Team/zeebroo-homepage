<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\PartnerCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A group on the /partners page, e.g. Technology partners, Payment partners or Retail clients.
 */
#[Fillable(['name', 'slug', 'icon', 'description', 'sort_order', 'is_active'])]
class PartnerCategory extends Model
{
    /** @use HasFactory<PartnerCategoryFactory> */
    use HasFactory, HasUniqueSlug;

    protected function slugSource(): string
    {
        return 'name';
    }

    /**
     * @return HasMany<Partner, $this>
     */
    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
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
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
