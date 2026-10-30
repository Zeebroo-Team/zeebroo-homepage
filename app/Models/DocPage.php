<?php

namespace App\Models;

use App\Models\Concerns\FlushesDocLibrary;
use App\Models\Concerns\HasTranslations;
use Database\Factories\DocPageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * One chapter of the user guide at /docs/{slug}. Its body is `intro`, then each section
 * (a doc-sec block with its heading), then `outro`; Sinhala copies fall back to English when empty.
 */
#[Fillable([
    'doc_group_id', 'slug', 'number', 'icon', 'title', 'title_si', 'description', 'description_si',
    'intro', 'intro_si', 'outro', 'outro_si', 'sort_order', 'is_active',
])]
class DocPage extends Model
{
    /** @use HasFactory<DocPageFactory> */
    use FlushesDocLibrary, HasFactory, HasTranslations;

    /**
     * Slugs taken by other /docs routes.
     */
    public const RESERVED_SLUGS = ['api'];

    protected function translatableAttributes(): array
    {
        return ['title', 'description', 'intro', 'outro'];
    }

    /**
     * @return BelongsTo<DocGroup, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(DocGroup::class, 'doc_group_id');
    }

    /**
     * @return HasMany<DocSection, $this>
     */
    public function sections(): HasMany
    {
        return $this->hasMany(DocSection::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @return HasMany<DocTask, $this>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(DocTask::class);
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Sidebar order: by group, then by the page's own order.
     *
     * @param  Builder<self>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->join('doc_groups', 'doc_groups.id', '=', 'doc_pages.doc_group_id')
            ->orderBy('doc_groups.sort_order')
            ->orderBy('doc_groups.id')
            ->orderBy('doc_pages.sort_order')
            ->orderBy('doc_pages.id')
            ->select('doc_pages.*');
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
