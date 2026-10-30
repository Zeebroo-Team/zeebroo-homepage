<?php

namespace Database\Factories;

use App\Models\SeoPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SeoPage>
 */
class SeoPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => 'home',
            'meta_title' => fake()->sentence(6),
            'meta_description' => fake()->sentence(18),
            'og_image_path' => null,
            'og_image_alt' => null,
        ];
    }

    public function withImage(string $path = 'seo/home.jpg'): static
    {
        return $this->state(fn (): array => ['og_image_path' => $path, 'og_image_alt' => fake()->sentence(4)]);
    }
}
