<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function store(array $data): Product
    {
        return $this->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function destroy(Product $product): void
    {
        $product->delete();
    }
}
