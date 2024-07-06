<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function create(array $data)
    {
        return Category::create($data);
    }

    public function getAll()
    {
        return Category::all();
    }

    public function getNestedCategories()
    {
        return Category::whereNull('parent_id')->with('childrenRecursive')->get();
    }
}