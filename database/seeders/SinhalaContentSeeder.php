<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Feature;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Fills the Sinhala (*_si) columns of the starter features, industries and blog content from
 * database/seeders/data/{features,industries,blogs}.si.php, matched by slug.
 *
 * Safe to run on a live database: a Sinhala field is only written when it is still empty
 * and its English counterpart still matches the starter text, so neither Sinhala written
 * in the admin panel nor translations of English that was since changed are touched.
 */
class SinhalaContentSeeder extends Seeder
{
    /**
     * Data file key => table column; the Sinhala column is the column plus "_si".
     *
     * @var array<string, string>
     */
    private const FIELDS = [
        'title' => 'title',
        'menu' => 'menu',
        'badge' => 'badge',
        'headline' => 'headline',
        'lead' => 'lead',
        'description' => 'meta_description',
    ];

    public function run(): void
    {
        $this->translate(Feature::class, 'features');
        $this->translate(Industry::class, 'industries');
        $this->translateBlog();
    }

    /**
     * Blog categories and posts; the English starter text lives in BlogSeeder.
     */
    private function translateBlog(): void
    {
        /** @var array{categories: array<string, array{name: string, description: string}>, posts: array<string, array{title: string, meta_title: string, meta_description: string, meta_keywords: string, body: string}>} $sinhala */
        $sinhala = require database_path('seeders/data/blogs.si.php');

        $categories = collect(BlogSeeder::CATEGORIES)->keyBy('slug');

        foreach (BlogCategory::query()->whereIn('slug', array_keys($sinhala['categories']))->get() as $category) {
            $this->fill($category, $categories[$category->slug] ?? null, $sinhala['categories'][$category->slug], [
                'name' => 'name',
                'description' => 'description',
            ]);
        }

        $posts = collect(BlogSeeder::posts())
            ->keyBy('slug')
            ->map(fn (array $post): array => ['body' => trim($post['body'])] + $post);

        foreach (Blog::query()->whereIn('slug', array_keys($sinhala['posts']))->get() as $blog) {
            $si = $sinhala['posts'][$blog->slug];
            $si['body'] = trim($si['body']);

            $this->fill($blog, $posts[$blog->slug] ?? null, $si, [
                'title' => 'title',
                'meta_title' => 'meta_title',
                'meta_description' => 'meta_description',
                'meta_keywords' => 'meta_keywords',
                'body' => 'description',
            ]);
        }
    }

    /**
     * @param  array<string, mixed>|null  $en
     * @param  array<string, mixed>  $si
     * @param  array<string, string>  $fields  data key => table column
     */
    private function fill(Model $record, ?array $en, array $si, array $fields): void
    {
        if ($en === null) {
            return;
        }

        foreach ($fields as $key => $column) {
            if (blank($record->{$column.'_si'}) && filled($si[$key] ?? null) && $record->{$column} === $en[$key]) {
                $record->{$column.'_si'} = $si[$key];
            }
        }

        $record->save();
    }

    /**
     * @param  class-string<Feature|Industry>  $model
     */
    private function translate(string $model, string $file): void
    {
        /** @var array<string, array<string, mixed>> $english */
        $english = require database_path("seeders/data/{$file}.php");
        /** @var array<string, array<string, mixed>> $sinhala */
        $sinhala = require database_path("seeders/data/{$file}.si.php");

        foreach ($model::query()->whereIn('slug', array_keys($sinhala))->get() as $record) {
            $en = $english[$record->slug] ?? null;
            $si = $sinhala[$record->slug];

            if ($en === null) {
                continue;
            }

            foreach (self::FIELDS as $key => $column) {
                if (blank($record->{$column.'_si'}) && filled($si[$key] ?? null) && $record->{$column} === $en[$key]) {
                    $record->{$column.'_si'} = $si[$key];
                }
            }

            if (blank($record->highlights_si) && array_column($record->highlights ?? [], 'title') === array_column($en['highlights'], 1)) {
                $record->highlights_si = array_map(fn (array $h): array => ['title' => $h[0], 'text' => $h[1]], $si['highlights']);
            }

            if (blank($record->capabilities_si) && $record->capabilities === $en['capabilities']) {
                $record->capabilities_si = $si['capabilities'];
            }

            $record->save();
        }
    }
}
