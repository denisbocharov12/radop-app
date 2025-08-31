<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Product;
use App\Repositories\ViewCount\ProductViewCountRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class IncrementProductViewCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $productId,
        private readonly string $ipAddress,
        private readonly string $sessionId,
        private readonly bool $shouldIncrement = true
    ) {
    }

    public function handle(ProductViewCountRepository $productViewCountRepository): void
    {
        $product = Product::find($this->productId);

        if ($product === null) {
            return;
        }

        $productViewCountRepository->updateOrCreateViewCountWithData(
            $this->productId,
            $this->ipAddress,
            $this->sessionId,
            $this->shouldIncrement
        );
    }
}
