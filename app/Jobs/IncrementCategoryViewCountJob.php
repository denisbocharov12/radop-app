<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Category;
use App\Repositories\ViewCount\CategoryViewCountRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class IncrementCategoryViewCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $categoryId,
        private readonly string $ipAddress,
        private readonly string $sessionId,
        private readonly bool $shouldIncrement = true
    ) {
    }

    public function handle(CategoryViewCountRepository $categoryViewCountRepository): void
    {
        $category = Category::find($this->categoryId);

        if ($category === null) {
            return;
        }

        $categoryViewCountRepository->updateOrCreateViewCountWithData(
            $this->categoryId,
            $this->ipAddress,
            $this->sessionId,
            $this->shouldIncrement
        );
    }
}
