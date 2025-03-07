<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Product;

class ProductController extends Controller
{
    // --- Get /api/products (Retrieve all products)
    public function getProducts(): JsonResponse {
        return response()->json(Product::all());
    }

    // --- Post /api/products
    public function createProduct(Request $request): JsonResponse {
        $product = Product::create($request->validate([
            'name' => 'required|string|max:255',
            'pricing' => 'required|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable|json',
            'category_id' => 'required|exists:categories,id',
        ]));
        return response()->json($product, 201);
    }

    // --- Get /api/products/{productId}
    public function getProduct($productId): JsonResponse {
        $product = Product::findOrFail($productId);
        return response()->json($product);
    }

    // --- Patch /api/products/{id} (Update a product)
    public function updateProduct(Request $request, $productId): JsonResponse {
        $product = Product::findOrFail($productId);

        $product->update($request->validate([
            'name' => 'string|max:255',
            'category_id' => 'exists:categories,id',
            'pricing' => 'numeric',
            'description' => 'nullable|string',
            'images' => 'nullable|json',
        ]));

        return response()->json($product);
    }

    // --- Delete /api/products/{id} (Delete a product)
    public function destroy($productId): JsonResponse {
        $product = Product::findOrFail($productId);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}

