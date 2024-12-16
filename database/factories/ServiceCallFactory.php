<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceCall>
 */
class ServiceCallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'callID' => $this->faker->randomNumber(8),
            'subject' => $this->faker->sentence(),
            'customer' => $this->faker->randomElement(['V', 'E', 'J']) . '-' . $this->faker->randomNumber(8),
            'custmrName' => $this->faker->name(),
            'contctCode' => $this->faker->randomNumber(8),
            'resolTime' => $this->faker->randomNumber(8),
            'free_1' => $this->faker->date(),
            'free_2' => $this->faker->sentence(),
            'origin' => $this->faker->randomElement(['DAEWOO', 'LENOVO', 'SAMSUNG']),
            'itemCode' => $this->faker->randomElement(['LM', 'LH', 'LB']) . ' - ' . $this->faker->randomNumber(8),
            'descrption' => $this->faker->text(),
            'createDate' => $this->faker->date(),
            'updateDate' => $this->faker->date(),
            'resolOnTim' => $this->faker->randomNumber(4),
            'respOnDate' => $this->faker->date(),
            'AssignDate' => $this->faker->date(),
            'AssignTime' => $this->faker->randomNumber(4),
            'UpdateTime' => $this->faker->randomNumber(4),
            'DocNum' => $this->faker->randomNumber(6),
            'Series' => 36,
            'Handwrtten' => 'N',
            'StartDate' => $this->faker->date(),
            'StartTime' => $this->faker->randomNumber(4),
            'EndDate' => $this->faker->date(),
            'EndTime' => $this->faker->randomNumber(4),
            'Duration' => $this->faker->randomNumber(3),
            'DurType' => 'S',
            'Reminder' => 'N',
            'RemQty' => 15,
            'RemType' => 'M',
            'Telephone' => $this->faker->phoneNumber(),
            'BPBillAddr' => $this->faker->address(),
            'U_DK_Marca' => $this->faker->randomElement(['DAEWOO', 'LENOVO', 'SAMSUNG']),
            'U_DK_TIENDA' => $this->faker->randomElement(['Sucursal Maracay Centro', 'Sucursal Valle La Pascua', 'Agencia Centro Valencia']),
            'U_DK_QUEJA' => $this->faker->uuid,
            'ASSIGNED_TECHNICIAN' => $this->faker->numberBetween(1, 20),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'Location' => $this->faker->address(),
        ];
    }
}
