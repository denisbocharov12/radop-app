<?php

declare(strict_types=1);

namespace App\Services\Category;

use App\Data\Category\CategoryData;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryUniqueNameException;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Services\Attachments\AttachmentsManager;
use App\Services\EntityStatusManager;

final class CategoryManager
{
    private CategoryRepository $categoryRepository;
    private AttachmentsManager $attachmentsManager;
    private EntityStatusManager $entityStatusManager;

    public function __construct(
        CategoryRepository  $categoryRepository,
        AttachmentsManager  $attachmentsManager,
        EntityStatusManager $entityStatusManager,
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->attachmentsManager = $attachmentsManager;
        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(CategoryData $categoryData, CategoryRequest $request): void
    {
        $existedCategory = $this->categoryRepository->getByName($categoryData->name);

        if ($existedCategory !== null) {
            throw new CategoryUniqueNameException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

        $category = Category::create([
            'name' => $categoryData->name,
            'parent_id' => $categoryData->parentId,
            'status' => $status,
            'summary' => $categoryData->summary
        ]);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $category);
    }

    public function update(CategoryData $categoryData, Category $category, CategoryRequest $request): void
    {
        if ($category->name !== $categoryData->name) {
            $existedCategory = $this->categoryRepository->getByName($categoryData->name);

            if ($existedCategory !== null) {
                throw new CategoryUniqueNameException();
            }
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

        $category->update([
            'name' => $categoryData->name,
            'parent_id' => $categoryData->parentId,
            'status' => $status,
            'summary' => $categoryData->summary
        ]);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $category);
    }

    public function delete(CategoryDeleteRequest $request): void
    {
        $categoryId = (int)$request->category_id;

        $category = $this->categoryRepository->getById($categoryId);

        if ($category === null) {
            throw new CategoryNotFoundException();
        }

        $category->delete();
    }
}
