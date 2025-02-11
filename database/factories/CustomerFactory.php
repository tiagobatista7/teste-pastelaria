<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('pt_BR');

        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail(),
            'phone' => $faker->phoneNumber(),
            'birth_date' => $faker->date(),
            'address' => $faker->streetAddress(),
            'complement' => $faker->secondaryAddress(),
            'neighborhood' => $faker->city(),
            'zip_code' => $faker->postcode(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
