<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ThemeExcelGroupedCategoryProductsExport;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

final class GenerateGroupedCategoryExcelExportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param string $parentCategoryOnecId
     * @param string $locale
     */
    public function __construct(
        private readonly string $parentCategoryOnecId,
        private readonly string $locale
    ) {
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return void
     */
    public function handle(CategoryRepository $categoryRepository): void
    {
        try {
            app()->setLocale($this->locale);

            $category = Category::query()
                ->where('onec_id', $this->parentCategoryOnecId)
                ->with(['childrenOrderedByColumn.childrenOrderedByColumn'])
                ->first();

            if ($category === null || !$category->children()->exists()) {
                return;
            }

            $groups = $categoryRepository->getProductGroupsByDirectChildrenForParentExport($category);

            if ($groups === []) {
                return;
            }

            $productTotal = 0;
            foreach ($groups as $g) {
                $productTotal += $g['products']->count();
            }
            if ($productTotal === 0) {
                return;
            }

            $fileName = "radop_categories_grouped_{$this->parentCategoryOnecId}_{$this->locale}.xlsx";
            $export = new ThemeExcelGroupedCategoryProductsExport($groups, $this->locale);

            Excel::store($export, $fileName, 'export');

            Log::info("Grouped category export created: {$fileName}", [
                'onec_id' => $this->parentCategoryOnecId,
                'locale' => $this->locale,
                'groups_count' => count($groups),
            ]);
        } catch (\Exception $e) {
            Log::error('Grouped category export failed', [
                'onec_id' => $this->parentCategoryOnecId,
                'locale' => $this->locale,
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);

            throw $e;
        }
    }
}
