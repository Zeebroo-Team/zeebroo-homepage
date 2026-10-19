<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\BlogTagFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'is_active'])]
class BlogTag extends Model
{
    /** @use HasFactory<BlogTagFactory> */
    use HasFactory, HasUniqueSlug;

    protected function slugSource(): string
    {
        return 'name';
    }

    /**
     * @return BelongsToMany<Blog, $this>
     */
    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class);
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
