<?php

namespace App\Models;

use App\Models\Concerns\FlushesDocLibrary;
use App\Models\Concerns\HasTranslations;
use Database\Factories\DocTaskFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A "Common tasks" shortcut on /docs, linking to one section of a page (/docs/{slug}#{anchor}).
 */
#[Fillable(['doc_page_id', 'anchor', 'icon', 'title', 'title_si', 'sort_order'])]
class DocTask extends Model
{
    /** @use HasFactory<DocTaskFactory> */
    use FlushesDocLibrary, HasFactory, HasTranslations;

    protected function translatableAttributes(): array
    {
        return ['title'];
    }

    /**
     * @return BelongsTo<DocPage, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(DocPage::class, 'doc_page_id');
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
        ];
    }
}
