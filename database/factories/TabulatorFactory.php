<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tabulator>
 */
class TabulatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'n' => $this->faker->randomNumber(8),
            'linea' => $this->faker->randomElement(['Linea Blanca', 'PC', 'Otros']),
            'gama' => $this->faker->randomElement(['Gama 1', 'Gama 2', 'Gama 3']),
            'producto' => $this->faker->randomElement(['Producto 1', 'Producto 2', 'Producto 3']),
            'familia' => $this->faker->randomElement(['Familia 1', 'Familia 2', 'Familia 3']),
            'repuestos' => $this->faker->randomElement(['Repuestos 1', 'Repuestos 2', 'Repuestos 3']),
            'costos_servicios' => $this->faker->randomNumber(3),
        ];
    }
}
