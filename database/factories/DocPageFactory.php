<?php

namespace Database\Factories;

use App\Models\DocGroup;
use App\Models\DocPage;
use App\Models\DocSection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DocPage>
 */
class DocPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'doc_group_id' => DocGroup::factory(),
            'slug' => Str::slug($title),
            'number' => fake()->numerify('##'),
            'icon' => 'fa-book',
            'title' => Str::ucfirst($title),
            'description' => fake()->sentence(14),
            'intro' => null,
            'outro' => null,
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => ['is_active' => false]);
    }

    /**
     * Adds standard sections with these anchors, in order.
     */
    public function withSections(string ...$anchors): static
    {
        return $this->afterCreating(function (DocPage $page) use ($anchors): void {
            foreach ($anchors as $order => $anchor) {
                DocSection::factory()->for($page, 'page')->create(['anchor' => $anchor, 'sort_order' => $order]);
            }
        });
    }
}
