<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Imports Zeebroo's starter industries from database/seeders/data/industries.php.
 * Runs only while the industries table is empty, so it never overwrites changes made in the admin panel.
 * Run it after FeatureSeeder so each industry's recommended modules can be linked.
 */
class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        if (Industry::query()->exists()) {
            return;
        }

        /** @var array<string, array<string, mixed>> $industries */
        $industries = require database_path('seeders/data/industries.php');

        $features = Feature::pluck('id', 'slug');

        foreach (array_keys($industries) as $position => $slug) {
            $i = $industries[$slug];

            $industry = Industry::create([
                'title' => $i['title'],
                'slug' => $slug,
                'menu' => $i['menu'],
                'icon' => $i['icon'],
                'badge' => $i['badge'],
                'headline' => $i['headline'],
                'lead' => $i['lead'],
                'highlights' => array_map(fn (array $h): array => ['icon' => $h[0], 'title' => $h[1], 'text' => $h[2]], $i['highlights']),
                'capabilities' => $i['capabilities'],
                'scene_path' => $this->copyImage($i['scene']),
                'meta_description' => $i['description'],
                'sort_order' => $position,
                'is_active' => true,
            ]);

            $industry->modules()->sync(
                collect($i['modules'])
                    ->filter(fn (string $featureSlug) => $features->has($featureSlug))
                    ->values()
                    ->mapWithKeys(fn (string $featureSlug, int $order) => [$features[$featureSlug] => ['sort_order' => $order]])
            );
        }
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

        $path = 'industries/'.basename($file);
        Storage::disk('public')->put($path, file_get_contents($source));

        return $path;
    }
}
