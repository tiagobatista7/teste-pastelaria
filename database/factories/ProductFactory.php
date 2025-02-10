<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => 'Pastel de ' . $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'photo' => 'products/' . $this->faker->unique()->uuid . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
