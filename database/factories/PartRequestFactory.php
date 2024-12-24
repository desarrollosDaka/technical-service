<?php

namespace Database\Factories;

use App\Enums\PartRequest\Status;
use App\Models\TechnicalVisit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PartRequest>
 */
class PartRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(array_map(fn($status) => $status->value, Status::cases()));

        return [
            'status' => $status,
            'name' => $this->faker->sentence,
            'observation' => $this->faker->text,
            'budget_amount' => $status === 6 ? $this->faker->randomNumber(4) : null,
            'date_handed' => $status === 4 ? now() : null,
            'meta' => [],
            'technical_visit_id' => TechnicalVisit::inRandomOrder()->first()->getKey(),
        ];
    }
}
