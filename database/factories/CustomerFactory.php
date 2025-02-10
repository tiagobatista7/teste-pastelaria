<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->streetAddress(),
            'complement' => $this->faker->secondaryAddress(),
            'neighborhood' => $this->faker->city(),
            'zip_code' => $this->faker->postcode(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
