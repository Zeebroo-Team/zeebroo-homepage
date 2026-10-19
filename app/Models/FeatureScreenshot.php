<?php

namespace App\Models;

use Database\Factories\FeatureScreenshotFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * A product screenshot shown in the gallery on a feature page.
 */
#[Fillable(['feature_id', 'path', 'caption', 'sort_order'])]
class FeatureScreenshot extends Model
{
    /** @use HasFactory<FeatureScreenshotFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Feature, $this>
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    protected function url(): Attribute
    {
        return Attribute::get(fn (): string => Storage::disk('public')->url($this->path));
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
