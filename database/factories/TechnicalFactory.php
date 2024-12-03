<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Technical>
 */
class TechnicalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Name_user_comercial' => $this->faker->company(),
            'User_name' => $this->faker->name(),
            'Email' => $this->faker->email(),
            'Password' => Hash::make('password'),
            'Identification_Comercial' => $this->faker->ean13(),
            'Phone' => $this->faker->phoneNumber(),
            'Address' => $this->faker->address(),
            'Tickets' => $this->faker->randomNumber(2),
            'Tickets_rejected' => $this->faker->randomNumber(2),
            'Qualification' => $this->faker->randomNumber(1),
            'ID_supplier' => $this->faker->ean13(),
            'Availability' => $this->faker->randomElement([0, 1]),
            'GeographicalCoordinates' => $this->faker->latitude(),
            'Create_date' => now(),
            'Update_date' => now(),
        ];
    }
}
