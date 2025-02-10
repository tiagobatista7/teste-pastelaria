<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json(Product::paginate(5));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->store($request->validated());
        return response()->json($product, Response::HTTP_CREATED);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $updatedProduct = $this->productService->update($product, $request->validated());
        return response()->json($updatedProduct, Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
