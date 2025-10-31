<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Responses\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $products = Product::with(['category', 'user'])->latest()->get();
        return $this->success($products, 'Products retrieved successfully');
    }

    // Create product
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated() + [
            'user_id' => auth('sanctum')->id(),
        ])->load(['category', 'user']);

        return $this->created($product, 'Product created successfully');
    }

    public function show(Product $product)
    {
        $product->loadMissing(['category', 'user']);
        return $this->success($product, 'Product retrieved successfully');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->loadMissing(['category', 'user']);

        return $this->success($product, 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->deleted('Product deleted successfully');
    }
}
