<?php

namespace Database\Factories;

use App\Enums\Ticket\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_call_id' => $this->faker->numberBetween(1, 50),
            'title' => $this->faker->sentence(),
            'diagnosis_date' => $this->faker->date(),
            'diagnosis_detail' => $this->faker->text(),
            'solution_date' => $this->faker->date(),
            'solution_detail' => $this->faker->text(),
            'reject_date' => $this->faker->date(),
            'reject_detail' => $this->faker->text(),
            'customer_name' => $this->faker->name,
            'status' => $this->faker->randomElement(
                array_map(fn($status) => $status->value, Status::cases())
            ),
            'total_cost' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
