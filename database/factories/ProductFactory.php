<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ItemCode' => $this->faker->randomNumber(8),
            'ItemName' => $this->faker->sentence(),
            'CodeBars' => $this->faker->ean13(),
            'U_DK_GARANTIA' => $this->faker->randomNumber(2),
            'U_FAMILIA' => $this->faker->randomElement(['Linea Blanca', 'PC', 'Otros']),
            'ItmsGrpNam' => $this->faker->randomElement(['Linea Blanca', 'PC', 'Otros']),
        ];
    }
}
