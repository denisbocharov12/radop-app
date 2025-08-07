<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\Product\ProductImagesManager;
use Illuminate\Console\Command;

final class OptimizeProductImagesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'products:optimize-images {--force : Принудительно переоптимизировать все изображения}';

    /**
     * @var string
     */
    protected $description = 'Оптимизация изображений для всех товаров';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info('Начинаем оптимизацию изображений товаров...');

        $query = Product::where('status', true);
        
        if (!$this->option('force')) {
            $query->whereHas('media', function ($q) {
                $q->where('collection_name', 'products');
            });
        }

        $products = $query->get();
        
        if ($products->isEmpty()) {
            $this->warn('Нет товаров с изображениями для оптимизации');
            return 0;
        }

        $this->info("Найдено товаров для оптимизации: {$products->count()}");

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $optimizedCount = 0;
        $skippedCount = 0;

        foreach ($products as $product) {
            try {
                if (ProductImagesManager::hasProductImages($product)) {
                    ProductImagesManager::reoptimizeProductImages($product);
                    $optimizedCount++;
                } else {
                    $skippedCount++;
                }
            } catch (\Exception $e) {
                $this->error("Ошибка при оптимизации изображений для товара {$product->onec_id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info("Оптимизация завершена!");
        $this->info("Оптимизировано: {$optimizedCount}");
        $this->info("Пропущено: {$skippedCount}");

        return 0;
    }
} 