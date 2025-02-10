<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $customer = Customer::factory()->create();
        $products = Product::factory()->count(5)->create();
        Order::factory()->create([
            'customer_id' => $customer->id,
            'product_id' => $products->random()->id,
        ]);
    }
}
