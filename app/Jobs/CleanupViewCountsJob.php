<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\ViewCount\BrandViewCountRepository;
use App\Repositories\ViewCount\CategoryViewCountRepository;
use App\Repositories\ViewCount\ProductViewCountRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class CleanupViewCountsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $days = 30
    ) {
    }

    public function handle(
        ProductViewCountRepository $productRepository,
        BrandViewCountRepository $brandRepository,
        CategoryViewCountRepository $categoryRepository
    ): void {
        $cutoffDate = Carbon::now()->subDays($this->days);

        try {
            $productCount = $productRepository->deleteOldRecords($cutoffDate);
            $brandCount = $brandRepository->deleteOldRecords($cutoffDate);
            $categoryCount = $categoryRepository->deleteOldRecords($cutoffDate);

            Log::info('View counts cleanup completed', [
                'days' => $this->days,
                'cutoff_date' => $cutoffDate,
                'deleted_records' => [
                    'products' => $productCount,
                    'brands' => $brandCount,
                    'categories' => $categoryCount,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('View counts cleanup failed', [
                'error' => $e->getMessage(),
                'days' => $this->days,
            ]);
            
            throw $e;
        }
    }
} 