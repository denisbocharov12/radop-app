<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\ViewCount\BrandViewCountRepository;
use App\Repositories\ViewCount\CategoryViewCountRepository;
use App\Repositories\ViewCount\ProductViewCountRepository;
use App\Services\ViewCount\ViewCountRecorder;
use Illuminate\Console\Command;

/**
 * Drains the cache view-buffer into the *_view_counts tables in one batch and
 * clears it. Scheduled every 15 minutes (see App\Console\Kernel). This replaces
 * the old per-request queued increment jobs.
 */
final class FlushViewCountsCommand extends Command
{
    protected $signature = 'view-counts:flush';

    protected $description = 'Flush buffered product/category/brand views from cache into the database.';

    public function handle(
        ViewCountRecorder $recorder,
        ProductViewCountRepository $productRepository,
        CategoryViewCountRepository $categoryRepository,
        BrandViewCountRepository $brandRepository
    ): int {
        $repositories = [
            'product'  => fn (int $id, string $ip, string $s, int $n) => $productRepository->addViewCount($id, $ip, $s, $n),
            'category' => fn (int $id, string $ip, string $s, int $n) => $categoryRepository->addViewCount($id, $ip, $s, $n),
            'brand'    => fn (int $id, string $ip, string $s, int $n) => $brandRepository->addViewCount($id, $ip, $s, $n),
        ];

        $buckets = 0;
        $views = 0;

        foreach ($repositories as $type => $write) {
            foreach ($recorder->drain($type) as $composite => $count) {
                $parts = explode('|', (string) $composite, 3);
                if (count($parts) < 3) {
                    continue;
                }
                [$id, $ip, $sessionId] = $parts;

                $write((int) $id, (string) $ip, (string) $sessionId, (int) $count);
                $buckets++;
                $views += (int) $count;
            }
        }

        $this->info("View flush complete: {$views} views across {$buckets} visitor buckets.");

        return self::SUCCESS;
    }
}
