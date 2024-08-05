<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnel>
 */
class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'personnel_code' => fake()->numberBetween(100000, 999999),
            'first_name' => Faker::firstName(),
            'last_name' => Faker::lastName(),
            'building' => fake()->numberBetween(1, 3),
            'room_number' => fake()->numberBetween(1, 50),
            'adder' => 1
        ];
    }
}
