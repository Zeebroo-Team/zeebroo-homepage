<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Imports Zeebroo's starter modules from database/seeders/data/features.php.
 * Runs only while the features table is empty, so it never overwrites changes made in the admin panel.
 */
class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        if (Feature::query()->exists()) {
            return;
        }

        /** @var array<string, array<string, mixed>> $features */
        $features = require database_path('seeders/data/features.php');

        $models = collect($features)->map(fn (array $f, string $slug) => Feature::create([
            'title' => $f['title'],
            'slug' => $slug,
            'menu' => $f['menu'],
            'icon' => $f['icon'],
            'group' => $f['group'],
            'badge' => $f['badge'],
            'headline' => $f['headline'],
            'lead' => $f['lead'],
            'highlights' => array_map(fn (array $h): array => ['icon' => $h[0], 'title' => $h[1], 'text' => $h[2]], $f['highlights']),
            'capabilities' => $f['capabilities'],
            'spot_path' => $this->copyImage($f['spot']),
            'scene_path' => $this->copyImage($f['scene']),
            'meta_description' => $f['description'],
            'sort_order' => array_search($slug, array_keys($features), true),
            'is_active' => true,
        ]));

        $models->each(function (Feature $feature, string $slug) use ($features, $models): void {
            $related = collect($features[$slug]['related'])
                ->filter(fn (string $relSlug) => $models->has($relSlug))
                ->values()
                ->mapWithKeys(fn (string $relSlug, int $i) => [$models[$relSlug]->id => ['sort_order' => $i]]);

            $feature->related()->sync($related);
        });
    }

    /**
     * Copies a bundled illustration from public/assets/features to the public disk.
     */
    private function copyImage(?string $file): ?string
    {
        $source = $file ? public_path('assets/features/'.$file) : null;

        if (! $source || ! is_file($source)) {
            return null;
        }

        $path = 'features/'.$file;
        Storage::disk('public')->put($path, file_get_contents($source));

        return $path;
    }
}
