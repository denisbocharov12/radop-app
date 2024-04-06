<?php

declare(strict_types=1);

namespace App\Services\Category;

use App\Data\Category\CategoryData;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryUniqueNameException;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
//use App\Services\EntityStatusManager;

final class CategoryManager
{
    private CategoryRepository $categoryRepository;
//    private EntityStatusManager $entityStatusManager;

    public function __construct(
        CategoryRepository $categoryRepository,
//        EntityStatusManager $entityStatusManager
    )
    {
        $this->categoryRepository = $categoryRepository;
//        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(CategoryData $categoryData): void
    {
        $existedCategory = $this->categoryRepository->getByName($categoryData->name);

        if ($existedCategory !== null) {
            throw new CategoryUniqueNameException();
        }

//        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

        Category::create([
           'name' => $categoryData->name,
           'parent_id' => $categoryData->parentId,
//           'status' => $status
        ]);
    }

    public function update(CategoryData $categoryData, Category $category): void
    {
        if ($category->name !== $categoryData->name)
        {
            $existedCategory = $this->categoryRepository->getByName($categoryData->name);

            if ($existedCategory === null) {
                throw new CategoryUniqueNameException();
            }
        }

//        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

        $category->update([
            'name' => $categoryData->name,
            'parent_id' => $categoryData->parentId,
//            'status' => $status
        ]);
    }

    public function delete(CategoryDeleteRequest $request): void
    {
        $categoryId = (int)$request->category_id;

        $category = $this->categoryRepository->getById($categoryId);

        if ($category === null)
        {
            throw new CategoryNotFoundException();
        }

        $category->delete();
    }
}
