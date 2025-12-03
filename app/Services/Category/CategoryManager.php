<?php

declare(strict_types=1);

namespace App\Services\Category;

use App\Data\Category\CategoryData;
use App\Exceptions\Attachments\AttachmentNotFoundException;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryUniqueNameException;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Media\ModelMediaDeleteRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Attachments\AttachmentsRepository;
use App\Repositories\Category\CategoryRepository;
use App\Services\Attachments\AttachmentsManager;
use App\Services\EntityStatusManager;
use App\Services\ONEC\ONECManager;
use Illuminate\Support\Facades\DB;

final class CategoryManager
{
    private CategoryRepository $categoryRepository;
    private AttachmentsManager $attachmentsManager;
    private AttachmentsRepository $attachmentsRepository;
    private EntityStatusManager $entityStatusManager;

    public function __construct(
        CategoryRepository  $categoryRepository,
        AttachmentsManager  $attachmentsManager,
        attachmentsRepository $attachmentsRepository,
        EntityStatusManager $entityStatusManager,
        private readonly ONECManager $ONECManager,
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->attachmentsManager = $attachmentsManager;
        $this->attachmentsRepository = $attachmentsRepository;
        $this->entityStatusManager = $entityStatusManager;
    }

    public function store(CategoryData $categoryData, CategoryRequest $request): void
    {
        $existedCategory = $this->categoryRepository->getByName($categoryData->name_ro);

        if ($existedCategory !== null) {
            throw new CategoryUniqueNameException();
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

        $category = Category::create([
            'name' => [
                'ro' => $categoryData->name_ro,
                'ru' => $categoryData->name_ru,
            ],
            'parent_id' => $categoryData->parentId,
            'status' => $status,
            'summary' => $categoryData->summary
        ]);

        $categoryOneCId = $this->ONECManager->getOneCIdForCreate($category);

        $category->update([
           'onec_id' => $categoryOneCId
        ]);

        $this->attachmentsManager->storeToMediaAttachmentsFromRequestToModel($request, $category);
    }

    public function update(CategoryData $categoryData, Category $category, CategoryRequest $request): void
    {
        if ($category->name !== $categoryData->name_ro) {
            $existedCategory = $this->categoryRepository->getByName($categoryData->name_ro);

            if ($existedCategory !== null) {
                throw new CategoryUniqueNameException();
            }
        }

        $status = $this->entityStatusManager->getEntityStatusFromRequest($categoryData->status);

        $category->update([
            'name' => [
                'ro' => $categoryData->name_ro,
                'ru' => $categoryData->name_ru,
            ],
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

    public function deleteMediaFromCategory(ModelMediaDeleteRequest $request, Category $category): void
    {
        $existedAttachment = $this->attachmentsRepository->getById($category, (int)$request->id);

        if ($existedAttachment === null)
        {
            throw new AttachmentNotFoundException();
        }

        $this->attachmentsManager->deleteAttachmentsFromModel($category, (int)$request->id);
    }

    /**
     * @param string $categoryOnecId
     * @param string $productOnecId
     * @param int $sort
     * @return void
     */
    public function updateProductSortInCategory(string $categoryOnecId, string $productOnecId, int $sort): void
    {
        DB::table('product_category_sorts')
            ->updateOrInsert(
                [
                    'category_id' => $categoryOnecId,
                    'product_id' => $productOnecId,
                ],
                [
                    'sort' => $sort,
                    'updated_at' => now(),
                ]
            );
    }
}
