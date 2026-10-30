<?php

namespace App\Models;

use App\Models\Concerns\FlushesDocLibrary;
use App\Models\Concerns\HasTranslations;
use Database\Factories\DocSectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One "On this page" topic of a docs page. A standard section is shown as
 * <div class="doc-sec"><h3 id="{anchor}">{heading}</h3>{body}</div>; a custom one
 * (`is_custom`, e.g. the What's new chapters) shows its body as written, which must
 * carry the element with id="{anchor}" itself.
 */
#[Fillable(['doc_page_id', 'anchor', 'heading', 'heading_si', 'body', 'body_si', 'is_custom', 'sort_order'])]
class DocSection extends Model
{
    /** @use HasFactory<DocSectionFactory> */
    use FlushesDocLibrary, HasFactory, HasTranslations;

    protected function translatableAttributes(): array
    {
        return ['heading', 'body'];
    }

    /**
     * @return BelongsTo<DocPage, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(DocPage::class, 'doc_page_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_custom' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
