<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\GenerateExcelExportJob;
use App\Jobs\GenerateGroupedCategoryExcelExportJob;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

final class GenerateExcelExportsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'excel:generate-exports';

    /**
     * @var string
     */
    protected $description = 'Generate Excel export files for all brands and categories';

    /**
     * @param BrandRepository $brandRepository
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @return void
     */
    public function handle(
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ): void {
        $this->info('Starting Excel export files generation...');

        $locales = ['ru', 'ro'];

        foreach ($locales as $locale) {
            app()->setLocale($locale);

            $this->info("Generating for locale: {$locale}");

            $brands = $brandRepository->getAllToFrontEnd();
            $this->info("Found brands: {$brands->count()}");

            foreach ($brands as $brand) {
                $products = $productRepository->getAllByBrandOnceIdForExport((int)$brand->onec_id);

                if ($products->isEmpty()) {
                    continue;
                }

                GenerateExcelExportJob::dispatch($products, 'brands', $brand->onec_id, $locale);

                $this->info("  - Brand {$brand->title} ({$brand->onec_id}): {$products->count()} products");
            }

            $categories = $categoryRepository->getAll();
            $this->info("Found categories: {$categories->count()}");

            foreach ($categories as $category) {
                if ($category->children()->exists()) {
                    GenerateGroupedCategoryExcelExportJob::dispatch($category->onec_id, $locale);
                    $this->info("  - Parent category {$category->name} ({$category->onec_id}): grouped export queued");

                    continue;
                }

                $products = $categoryRepository->getAllByCategoryOnecIdForExport($category);

                if ($products === null || $products->isEmpty()) {
                    continue;
                }

                GenerateExcelExportJob::dispatch($products, 'categories', $category->onec_id, $locale);

                $this->info("  - Category {$category->name} ({$category->onec_id}): {$products->count()} products");
            }

            $newProducts = $productRepository->getAllNewProductsForExport();
            if ($newProducts->isNotEmpty()) {
                GenerateExcelExportJob::dispatch($newProducts, 'new_products', 'new', $locale);
                $this->info("  - New products: {$newProducts->count()} products");
            }

            $popularProducts = $productRepository->getAllPopularProductsForExport();
            if ($popularProducts->isNotEmpty()) {
                GenerateExcelExportJob::dispatch($popularProducts, 'popular_products', 'popular', $locale);
                $this->info("  - Popular products: {$popularProducts->count()} products");
            }

            $saleProducts = $productRepository->getAllDiscountProductsForExport();
            if ($saleProducts->isNotEmpty()) {
                GenerateExcelExportJob::dispatch($saleProducts, 'sale_products', 'sale', $locale);
                $this->info("  - Sale products: {$saleProducts->count()} products");
            }
        }

        Log::info('Excel export files successfully added to queue');
        $this->info('All export files have been added to the queue!');
    }
}

