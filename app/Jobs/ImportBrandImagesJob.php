<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Services\Brand\BrandImagesManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class ImportBrandImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param array $brandIds
     * @param bool $force
     */
    public function __construct(
        private readonly array $brandIds,
        private readonly bool $force = false
    ) {}

    /**
     * @return void
     */
    public function handle(): void
    {
        $brands = Brand::whereIn('id', $this->brandIds)->get();

        foreach ($brands as $brand) {
            try {
                if ($this->force) {
                    BrandImagesManager::clearBrandImages($brand);
                }

                if (!BrandImagesManager::hasBrandImages($brand)) {
                    BrandImagesManager::importBrandImages($brand);
                }
            } catch (\Exception $e) {
                Log::error("Ошибка при импорте изображений для бренда {$brand->onec_id}: {$e->getMessage()}", [
                    'brand_id' => $brand->id,
                    'onec_id' => $brand->onec_id,
                    'exception' => $e
                ]);
            }
        }
    }
}


