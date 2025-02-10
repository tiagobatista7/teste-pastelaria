<?php

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

test('cria um pedido', function () {
    $customer = Customer::factory()->create();
    $product = Product::factory()->create();

    $data = [
        'customer_id' => $customer->id,
        'product_id' => $product->id,
    ];

    $orderService = new OrderService();
    $order = $orderService->store($data);

    $this->assertDatabaseHas('orders', [
        'customer_id' => $customer->id,
        'product_id' => $product->id,
    ]);
    $this->assertInstanceOf(Order::class, $order);
});


test('atualiza um pedido', function () {
    $customer = Customer::factory()->create();
    $productOriginal = Product::factory()->create();

    $order = Order::factory()->create([
        'customer_id' => $customer->id,
        'product_id' => $productOriginal->id,
    ]);

    $productNew = Product::factory()->create();

    $newData = [
        'product_id' => $productNew->id,
    ];

    $orderService = new OrderService();
    $updatedOrder = $orderService->update($order, $newData);

    $this->assertDatabaseHas('orders', [
        'id' => $updatedOrder->id,
        'customer_id' => $customer->id,
        'product_id' => $productNew->id,
    ]);

    $this->assertEquals($productNew->id, $updatedOrder->product_id);
});
