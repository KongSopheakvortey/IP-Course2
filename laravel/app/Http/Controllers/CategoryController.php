<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    // --- Get /api/categories
    public function getCategories(): JsonResponse{
        return response()->json(Category::all());
    }

    // --- Post /api/categories
    public function createCategory(Request $request){
        $category = Category::create($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return response()->json($category, 201);
    }

    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId){
        $category = Category::with('products')->findOrFail($categoryId); 
        return response()->json($category);
    }

    // --- Patch /api/categories/{categoryId}
    public function updateCategory(Request $request, $categoryId){
        $category = Category::findOrFail($categoryId);

        $category->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]));

        return response()->json($category);
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId){
        $category = Category::findOrFail($categoryId);

        $category->delete();
        return response()->json(["message" => "Category deleted successfully"]);
    }
}
