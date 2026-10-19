<?php

namespace Database\Factories;

use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'business' => fake()->company(),
            'topic' => fake()->randomElement(array_keys(Enquiry::TOPICS)),
            'message' => fake()->paragraph(),
            'status' => Enquiry::STATUS_NEW,
            'notes' => null,
            'ip_address' => fake()->ipv4(),
        ];
    }

    public function status(string $status): static
    {
        return $this->state(fn (): array => ['status' => $status]);
    }
}
