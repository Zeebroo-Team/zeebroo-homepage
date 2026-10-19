<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Industry>
 */
class IndustryFactory extends Factory
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
            'icon' => 'fa-briefcase',
            'badge' => null,
            'headline' => rtrim(fake()->sentence(6), '.'),
            'lead' => fake()->paragraph(),
            'highlights' => collect(range(1, 3))->map(fn (): array => [
                'icon' => 'fa-check',
                'title' => Str::title(fake()->words(2, true)),
                'text' => fake()->sentence(),
            ])->all(),
            'capabilities' => fake()->sentences(4),
            'scene_path' => null,
            'meta_title' => null,
            'meta_description' => fake()->sentence(14),
            'meta_keywords' => implode(', ', fake()->words(3)),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
