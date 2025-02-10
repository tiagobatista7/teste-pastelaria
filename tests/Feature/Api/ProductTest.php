<?php

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('lista todos os produtos', function () {
    Product::factory()->count(5)->create();

    $response = $this->getJson('/products');

    $response->assertStatus(200)
        ->assertJsonCount(5, 'data');
});

test('cria um produto', function () {
    $data = [
        'name' => 'Produto Teste',
        'price' => 99.99,
        'photo' => 'default.jpg',
    ];

    $productService = new ProductService();
    $product = $productService->create($data);

    $this->assertDatabaseHas('products', [
        'name' => 'Produto Teste',
        'price' => 99.99,
        'photo' => 'default.jpg',
    ]);

    $this->assertInstanceOf(Product::class, $product);
});

test('exibe um produto', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/products/{$product->id}");

    $response->assertStatus(200)
        ->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
        ]);
});

test('atualiza um produto', function () {
    $product = Product::factory()->create([
        'name' => 'Nome Antigo',
        'price' => 50.00,
    ]);

    $newData = [
        'name' => 'Nome Atualizado',
        'price' => 75.00,
    ];

    $productService = new ProductService();
    $updatedProduct = $productService->update($product, $newData);

    $this->assertDatabaseHas('products', [
        'id' => $updatedProduct->id,
        'name' => 'Nome Atualizado',
        'price' => 75.00,
    ]);

    $this->assertEquals('Nome Atualizado', $updatedProduct->name);
    $this->assertEquals(75.00, $updatedProduct->price);
});

test('exclui um produto', function () {
    $product = Product::factory()->create();

    $productService = new ProductService();
    $productService->destroy($product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'deleted_at' => now(),
    ]);
});
