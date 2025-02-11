<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ProductService;
use Mockery;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
    }

    public function test_create_a_product(): void
    {
        $data = [
            'name' => 'Produto Teste',
            'price' => 99.99,
            'photo' => 'default.jpg',
        ];

        $mockProductService = Mockery::mock(ProductService::class)->makePartial();
        $mockProductService->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn(new Product($data));

        $product = $mockProductService->create($data);
        $this->assertEquals($data['name'], $product->name);
        $this->assertEquals($data['price'], $product->price);
        $this->assertEquals($data['photo'], $product->photo);
    }

    public function test_update_a_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Nome Antigo',
            'price' => 50.00,
        ]);

        $newData = [
            'name' => 'Nome Atualizado',
            'price' => 75.00,
        ];

        $mockProductService = Mockery::mock(ProductService::class)->makePartial();
        $mockProductService->shouldReceive('update')
            ->once()
            ->with($product, $newData)
            ->andReturnUsing(function ($product, $newData) {
                $product->name = $newData['name'];
                $product->price = $newData['price'];
                return $product;
            });

        $updatedProduct = $mockProductService->update($product, $newData);
        $this->assertEquals($newData['name'], $updatedProduct->name);
        $this->assertEquals($newData['price'], $updatedProduct->price);
    }

    public function test_exclude_a_product(): void
    {
        $product = Product::factory()->create();

        $mockProductService = Mockery::mock(ProductService::class);
        $mockProductService->shouldReceive('destroy')
            ->once()
            ->with($product)
            ->andReturn(null);


        $mockProductService->destroy($product);
        $mockProductService->shouldHaveReceived('destroy')
            ->once()
            ->with($product);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'deleted_at' => null,
        ]);
    }
}
