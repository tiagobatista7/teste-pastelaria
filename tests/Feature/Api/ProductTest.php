<?php

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('list all products', function () {
    Product::factory()->count(5)->create();

    $response = $this->getJson('/products');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'data');
});

test('create a product', function () {
    $data = [
        'name' => 'Product testing',
        'price' => 99.99,
        'photo' => 'default.jpg',
    ];

    $productService = new ProductService();
    $product = $productService->create($data);

    $this->assertDatabaseHas('products', [
        'name' => 'Product testing',
        'price' => 99.99,
        'photo' => 'default.jpg',
    ]);

    $this->assertInstanceOf(Product::class, $product);
});

test('displays a product', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/products/{$product->id}");

    $response->assertStatus(200)
        ->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
        ]);
});

test('update a product', function () {
    $product = Product::factory()->create([
        'name' => 'old name',
        'price' => 50.00,
    ]);

    $newData = [
        'name' => 'updated name',
        'price' => 75.00,
    ];

    $productService = new ProductService();
    $updatedProduct = $productService->update($product, $newData);

    $this->assertDatabaseHas('products', [
        'id' => $updatedProduct->id,
        'name' => 'updated name',
        'price' => 75.00,
    ]);

    $this->assertEquals('updated name', $updatedProduct->name);
    $this->assertEquals(75.00, $updatedProduct->price);
});

test('delete a product', function () {
    $product = Product::factory()->create();

    $productService = new ProductService();
    $productService->destroy($product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'deleted_at' => now(),
    ]);
});
