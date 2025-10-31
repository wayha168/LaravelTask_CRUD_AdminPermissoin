<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Responses\ApiResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    // List all categories
    public function index()
    {
        $categories = Category::all();
        return $this->success($categories, 'Categories retrieved successfully');
    }

    // Create new category
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->created($category, 'Category created successfully');
    }

    // Show single category
    public function show(Category $category)
    {
        return $this->success($category, 'Category retrieved successfully');
    }

    // Update category
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $this->success($category, 'Category updated successfully');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->deleted('Category deleted successfully');
    }
}
