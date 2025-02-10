<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->store($request->validated());

        return response()->json($order, Response::HTTP_CREATED);
    }

    public function show(Order $order)
    {
        return response()->json($order, 200);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $updatedOrder = $this->orderService->update($order, $request->validated());
        return response()->json($updatedOrder, 200);
    }

    public function destroy(Order $order)
    {
        $this->orderService->destroy($order);
        return response()->json(null, 204);
    }
}
