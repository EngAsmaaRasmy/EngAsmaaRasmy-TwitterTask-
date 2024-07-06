<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('category');
    }

    public function getCategories()
    {
        $categories = $this->categoryService->getNestedCategories();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category = $this->categoryService->create($request->all());
        return response()->json($category);
    }
}
