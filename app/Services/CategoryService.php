<?php
namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function getNestedCategories()
    {
        return $this->categoryRepository->getNestedCategories();
    }
}