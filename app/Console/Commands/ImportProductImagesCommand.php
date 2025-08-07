<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\Product\ProductImagesManager;
use Illuminate\Console\Command;

final class ImportProductImagesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'products:import-images {--force : Принудительно переимпортировать все изображения}';

    /**
     * @var string
     */
    protected $description = 'Импорт и оптимизация изображений для всех товаров';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info('Начинаем импорт изображений товаров...');

        $query = Product::where('status', true);
        
        if (!$this->option('force')) {
            $query->whereDoesntHave('media', function ($q) {
                $q->where('collection_name', 'products');
            });
        }

        $products = $query->get();
        
        if ($products->isEmpty()) {
            $this->warn('Нет товаров для импорта изображений');
            return 0;
        }

        $this->info("Найдено товаров для обработки: {$products->count()}");

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($products as $product) {
            try {
                if ($this->option('force')) {
                    ProductImagesManager::clearProductImages($product);
                }

                if (!ProductImagesManager::hasProductImages($product)) {
                    ProductImagesManager::importProductImages($product);
                    $importedCount++;
                } else {
                    $skippedCount++;
                }
            } catch (\Exception $e) {
                $this->error("Ошибка при импорте изображений для товара {$product->onec_id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info("Импорт завершен!");
        $this->info("Импортировано: {$importedCount}");
        $this->info("Пропущено: {$skippedCount}");

        return 0;
    }
} 