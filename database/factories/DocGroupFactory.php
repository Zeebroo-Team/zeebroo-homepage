<?php

namespace Database\Factories;

use App\Models\DocGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DocGroup>
 */
class DocGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'key' => Str::slug($name),
            'name' => Str::ucfirst($name),
            'name_si' => null,
            'sort_order' => 0,
        ];
    }
}
