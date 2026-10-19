<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(2, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'menu' => fake()->sentence(4),
            'icon' => 'fa-puzzle-piece',
            'group' => 'suite',
            'badge' => null,
            'headline' => rtrim(fake()->sentence(6), '.'),
            'lead' => fake()->paragraph(),
            'highlights' => collect(range(1, 3))->map(fn (): array => [
                'icon' => 'fa-check',
                'title' => Str::title(fake()->words(2, true)),
                'text' => fake()->sentence(),
            ])->all(),
            'capabilities' => fake()->sentences(4),
            'spot_path' => null,
            'scene_path' => null,
            'meta_title' => null,
            'meta_description' => fake()->sentence(14),
            'meta_keywords' => implode(', ', fake()->words(3)),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function core(): static
    {
        return $this->state(fn (): array => ['group' => 'core']);
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
