<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class OrderService
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function store(array $data)
    {
        return $this->create($data);
    }

    public function update(Order $order, array $data)
    {
        // Verifica se o produto existe antes de atualizar
        if (isset($data['product_id'])) {
            $productExists = Product::find($data['product_id']);
            if (!$productExists) {
                throw new \Exception("Produto não encontrado");
            }
        }

        $order->update($data);

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return $order;
    }
}
