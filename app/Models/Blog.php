<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use App\Models\Concerns\HasUniqueSlug;
use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'title', 'title_si', 'slug', 'meta_title', 'meta_title_si', 'meta_description', 'meta_description_si',
    'meta_keywords', 'meta_keywords_si', 'category_id', 'author_name', 'published_at', 'description',
    'description_si', 'image_path', 'is_active',
])]
class Blog extends Model
{
    /** @use HasFactory<BlogFactory> */
    use HasFactory, HasTranslations, HasUniqueSlug;

    protected function slugSource(): string
    {
        return 'title';
    }

    protected function translatableAttributes(): array
    {
        return ['title', 'meta_title', 'meta_description', 'meta_keywords', 'description'];
    }

    /**
     * @return BelongsTo<BlogCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * @return BelongsToMany<BlogTag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class);
    }

    /**
     * Active posts whose publish date has arrived.
     *
     * @param  Builder<self>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Public URL of the featured image, or null when none is uploaded.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->image_path ? Storage::disk('public')->url($this->image_path) : null);
    }

    /**
     * Plain-text summary for cards and meta fallbacks.
     */
    protected function excerpt(): Attribute
    {
        return Attribute::get(fn (): string => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $this->description))), 160));
    }

    /**
     * Estimated reading time in minutes.
     */
    protected function readingMinutes(): Attribute
    {
        // split on whitespace rather than str_word_count(), which only counts Latin letters and misses Sinhala words
        $words = fn (): int => count(preg_split('/\s+/u', strip_tags((string) $this->description), -1, PREG_SPLIT_NO_EMPTY));

        return Attribute::get(fn (): int => max(1, (int) ceil($words() / 200)));
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
