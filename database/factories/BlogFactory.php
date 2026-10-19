<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = rtrim(fake()->unique()->sentence(6), '.');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(18),
            'meta_keywords' => implode(', ', fake()->words(4)),
            'category_id' => BlogCategory::factory(),
            'author_name' => fake()->name(),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'description' => collect(fake()->paragraphs(5))->map(fn (string $p): string => "<p>{$p}</p>")->implode(''),
            'image_path' => null,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (): array => ['published_at' => now()->addWeek()]);
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['published_at' => null]);
    }
}
