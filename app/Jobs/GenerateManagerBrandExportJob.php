<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exports\ThemeExcelGroupedCategoryProductsExport;
use App\Models\User;
use App\Repositories\Brand\BrandRepository;
use App\Services\Export\ProductCategoryGrouper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @param Collection $products
 * @param string $brandId
 * @param string $locale
 * @param User $manager
 */
final class GenerateManagerBrandExportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param Collection $products
     * @param string $brandId
     * @param string $locale
     * @param User $manager
     */
    public function __construct(
        private readonly Collection $products,
        private readonly string $brandId,
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

            $brandRepository = app(BrandRepository::class);
            $brand = $brandRepository->getByOnecId($this->brandId);

            if (!$brand) {
                throw new \Exception("Бренд с ID {$this->brandId} не найден");
            }

            $brandName = $brand->getTranslation('title', $this->locale);
            $safeBrandName = Str::slug($brandName, '_');
            $fileName = "Бренд_{$safeBrandName}_{$this->locale}.xlsx";
            $filePath = $fileName;

            // Group by category so the brand export shows the same yellow
            // per-category sub-headers as the storefront catalogs.
            $this->products->loadMissing([
                'categories:id,onec_id,name',
                'brand:id,onec_id,title',
                'packages',
                'values.attribute',
                'media',
                'data',
            ]);

            $groups = app(ProductCategoryGrouper::class)->group($this->products, $this->locale);

            $export = new ThemeExcelGroupedCategoryProductsExport(
                $groups,
                $this->locale,
                'frontend.v1.exports.manager_categories_grouped_export',
            );

            Excel::store($export, $filePath, 'manager_exports');

            Log::info("Экспорт бренда для менеджера успешно создан", [
                'manager_id' => $this->manager->id,
                'brand_id' => $this->brandId,
                'locale' => $this->locale,
                'products_count' => $this->products->count(),
                'file_name' => $fileName,
            ]);
        } catch (\Exception $e) {
            Log::error("Ошибка экспорта бренда для менеджера", [
                'manager_id' => $this->manager->id,
                'brand_id' => $this->brandId,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}

