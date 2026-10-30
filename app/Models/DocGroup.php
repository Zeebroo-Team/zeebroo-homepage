<?php

namespace App\Models;

use App\Models\Concerns\FlushesDocLibrary;
use App\Models\Concerns\HasTranslations;
use Database\Factories\DocGroupFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A heading in the /docs sidebar, e.g. "Selling & stock". Groups and their pages are listed by sort order.
 */
#[Fillable(['key', 'name', 'name_si', 'sort_order'])]
class DocGroup extends Model
{
    /** @use HasFactory<DocGroupFactory> */
    use FlushesDocLibrary, HasFactory, HasTranslations;

    protected function translatableAttributes(): array
    {
        return ['name'];
    }

    /**
     * @return HasMany<DocPage, $this>
     */
    public function pages(): HasMany
    {
        return $this->hasMany(DocPage::class);
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
