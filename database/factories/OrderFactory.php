<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'product_id' => Customer::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withproducts()
    {
        return $this->afterCreating(function (Order $order) {
            $products = Order::factory(2)->create();
            $order->products()->attach($products->pluck('id')->toArray());
        });
    }
}
