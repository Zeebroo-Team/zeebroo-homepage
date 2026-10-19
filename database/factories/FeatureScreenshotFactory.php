<?php

namespace Database\Factories;

use App\Models\Feature;
use App\Models\FeatureScreenshot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeatureScreenshot>
 */
class FeatureScreenshotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'feature_id' => Feature::factory(),
            'path' => 'features/screenshots/'.fake()->uuid().'.png',
            'caption' => fake()->sentence(4),
            'sort_order' => 0,
        ];
    }
}
