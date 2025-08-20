<?php

namespace App\Jobs;

use App\Models\Brand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\Conversions\FileManipulator;

final class OptimizeBrandImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @param array<int> $brandIds
     * @param bool $onlyMissing
     */
    public function __construct(
        private readonly array $brandIds,
        private readonly bool $onlyMissing = true
    ) {}

    /**
     * @param FileManipulator $fileManipulator
     * @return void
     */
    public function handle(FileManipulator $fileManipulator): void
    {
        $brands = Brand::whereIn('id', $this->brandIds)->get();

        foreach ($brands as $brand) {
            try {
                $mediaItems = $brand->getMedia('media');

                if ($mediaItems->isEmpty()) {
                    continue;
                }

                foreach ($mediaItems as $media) {
                    $fileManipulator->createDerivedFiles($media, [], $this->onlyMissing, false);
                }
            } catch (\Throwable $e) {
                Log::error("Ошибка при оптимизации конверсий изображений бренда {$brand->onec_id}: {$e->getMessage()}", [
                    'brand_id' => $brand->id,
                    'onec_id' => $brand->onec_id,
                    'exception' => $e,
                ]);
            }
        }
    }
}


