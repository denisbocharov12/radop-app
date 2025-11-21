<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ManagerExcelProductsExport;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @param Collection $products
 * @param string $categoryId
 * @param string $locale
 * @param User $manager
 */
final class GenerateManagerCategoryExportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param Collection $products
     * @param string $categoryId
     * @param string $locale
     * @param User $manager
     */
    public function __construct(
        private readonly Collection $products,
        private readonly string $categoryId,
        private readonly string $locale,
        private readonly User $manager
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            if (!$this->manager->exists) {
                throw new \Exception("Менеджер {$this->manager->id} больше не существует");
            }

            app()->setLocale($this->locale);

            $categoryRepository = app(CategoryRepository::class);
            $category = $categoryRepository->getByOnecId($this->categoryId);

            if (!$category) {
                throw new \Exception("Категория с ID {$this->categoryId} не найдена");
            }

            $categoryPath = $this->getCategoryPath($category);
            $safeCategoryPath = Str::slug($categoryPath, '_');
            $fileName = "Категория_{$safeCategoryPath}_{$this->locale}.xlsx";
            $filePath = $fileName;

            $export = new ManagerExcelProductsExport($this->products, $this->locale);

            Excel::store($export, $filePath, 'manager_exports');

            Log::info("Экспорт категории для менеджера успешно создан", [
                'manager_id' => $this->manager->id,
                'category_id' => $this->categoryId,
                'locale' => $this->locale,
                'products_count' => $this->products->count(),
                'file_name' => $fileName,
            ]);
        } catch (\Exception $e) {
            Log::error("Ошибка экспорта категории для менеджера", [
                'manager_id' => $this->manager->id,
                'category_id' => $this->categoryId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * @param Category $category
     * @return string
     */
    private function getCategoryPath(Category $category): string
    {
        $pathParts = [];
        $currentCategory = $category;

        while ($currentCategory) {
            $categoryName = $currentCategory->getTranslation('name', $this->locale);
            array_unshift($pathParts, $categoryName);
            $currentCategory = $currentCategory->parent;
        }

        return implode('_', $pathParts);
    }
}

