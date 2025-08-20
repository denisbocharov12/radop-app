<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Services\Brand\BrandImagesManager;
use Illuminate\Console\Command;

final class ImportBrandImagesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'brands:import-images {--force : Принудительно переимпортировать все изображения}';

    /**
     * @var string
     */
    protected $description = 'Импорт и оптимизация изображений для всех брендов';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info('Начинаем импорт изображений брендов...');

        $query = Brand::where('status', true);

        if (!$this->option('force')) {
            $query->whereDoesntHave('media', function ($q) {
                $q->where('collection_name', 'media');
            });
        }

        $brands = $query->get();

        if ($brands->isEmpty()) {
            $this->warn('Нет брендов для импорта изображений');
            return 0;
        }

        $this->info("Найдено брендов для обработки: {$brands->count()}");

        $bar = $this->output->createProgressBar($brands->count());
        $bar->start();

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($brands as $brand) {
            try {
                if ($this->option('force')) {
                    BrandImagesManager::clearBrandImages($brand);
                }

                if (!BrandImagesManager::hasBrandImages($brand)) {
                    BrandImagesManager::importBrandImages($brand);
                    $importedCount++;
                } else {
                    $skippedCount++;
                }
            } catch (\Exception $e) {
                $this->error("Ошибка при импорте изображений для бренда {$brand->onec_id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info('Импорт завершен!');
        $this->info("Импортировано: {$importedCount}");
        $this->info("Пропущено: {$skippedCount}");

        return 0;
    }
}


