<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\BlogCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description', 'is_active'])]
class BlogCategory extends Model
{
    /** @use HasFactory<BlogCategoryFactory> */
    use HasFactory, HasUniqueSlug;

    protected function slugSource(): string
    {
        return 'name';
    }

    /**
     * @return HasMany<Blog, $this>
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
