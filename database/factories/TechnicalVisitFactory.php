<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TechnicalVisits>
 */
class TechnicalVisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'visit_date' => $this->faker->date(),
            'observation' => $this->faker->text(),
            'ticket_id' => Ticket::inRandomOrder()->first()->getKey(),
        ];
    }
}
