<?php

namespace Database\Factories;

use App\Models\DocPage;
use App\Models\DocSection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DocSection>
 */
class DocSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $heading = fake()->unique()->words(3, true);

        return [
            'doc_page_id' => DocPage::factory(),
            'anchor' => Str::slug($heading),
            'heading' => Str::ucfirst($heading),
            'body' => '<p>'.fake()->sentence(12).'</p>',
            'is_custom' => false,
            'sort_order' => 0,
        ];
    }
}
