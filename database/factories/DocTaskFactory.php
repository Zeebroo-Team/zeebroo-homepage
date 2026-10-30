<?php

namespace Database\Factories;

use App\Models\DocPage;
use App\Models\DocTask;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DocTask>
 */
class DocTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doc_page_id' => DocPage::factory(),
            'anchor' => 'overview',
            'icon' => 'fa-check',
            'title' => Str::ucfirst(fake()->words(3, true)),
            'sort_order' => 0,
        ];
    }
}
