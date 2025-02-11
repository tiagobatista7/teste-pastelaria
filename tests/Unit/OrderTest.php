<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        Artisan::call('migrate');
    }

    public function test_create_an_order(): void
    {
        $customer = Customer::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
        ];

        $mockOrderRepository = Mockery::mock(OrderRepository::class)->makePartial();
        $mockOrderRepository->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn(new Order($data));

        $order = $mockOrderRepository->create($data);

        $this->assertEquals($data['customer_id'], $order->customer_id);
        $this->assertEquals($data['product_id'], $order->product_id);
    }

    public function test_update_an_order(): void
    {
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

        $mockOrderRepository = Mockery::mock(OrderRepository::class)->makePartial();
        $mockOrderRepository->shouldReceive('update')
            ->once()
            ->with($order->id, $newData)
            ->andReturnUsing(function ($id, $data) use ($order, $productNew) {
                $order->product_id = $data['product_id'];
                return $order;
            });

        $updatedOrder = $mockOrderRepository->update($order->id, $newData);
        $this->assertEquals($productNew->id, $updatedOrder->product_id);
    }
}
