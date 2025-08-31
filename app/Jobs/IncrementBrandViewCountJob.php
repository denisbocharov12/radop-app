<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Brand;
use App\Repositories\ViewCount\BrandViewCountRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class IncrementBrandViewCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $brandId,
        private readonly string $ipAddress,
        private readonly string $sessionId,
        private readonly bool $shouldIncrement = true
    ) {
    }

    public function handle(BrandViewCountRepository $brandViewCountRepository): void
    {
        $brand = Brand::find($this->brandId);

        if ($brand === null) {
            return;
        }

        $brandViewCountRepository->updateOrCreateViewCountWithData(
            $this->brandId,
            $this->ipAddress,
            $this->sessionId,
            $this->shouldIncrement
        );
    }
}
