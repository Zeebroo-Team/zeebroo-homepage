<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\PartnerCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'partner_category_id' => PartnerCategory::factory(),
            'name' => fake()->unique()->company(),
            'logo_path' => null,
            'website_url' => fake()->url(),
            'tagline' => fake()->catchPhrase(),
            'description' => fake()->sentence(16),
            'location' => fake()->city().', '.fake()->country(),
            'since_year' => fake()->numberBetween(2018, 2026),
            'is_featured' => false,
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (): array => ['is_featured' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }
}
