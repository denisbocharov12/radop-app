<?php

declare(strict_types=1);

namespace App\Services\ViewCount;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Thin entry point used by the storefront controllers. Delegates to the batched
 * ViewCountRecorder (cache buffer + 15-min flush) — no per-request queued job.
 */
final class ViewCountManager
{
    public function __construct(
        private readonly ViewCountRecorder $recorder,
    ) {
    }

    public function incrementProductViewCount(Product $product, Request $request): void
    {
        $this->record('product', $product->id, $request);
    }

    public function incrementBrandViewCount(Brand $brand, Request $request): void
    {
        $this->record('brand', $brand->id, $request);
    }

    public function incrementCategoryViewCount(Category $category, Request $request): void
    {
        $this->record('category', $category->id, $request);
    }

    private function record(string $type, int $id, Request $request): void
    {
        $this->recorder->record(
            $type,
            $id,
            $this->getClientIp($request),
            $request->session()->getId(),
            $request->userAgent()
        );
    }

    /**
     * Trusted client IP. Relies on Laravel's TrustProxies configuration instead of
     * blindly reading spoofable X-Forwarded-* headers (which used to inflate unique
     * view counts by creating a new bucket per forged header).
     */
    public function getClientIp(Request $request): string
    {
        return (string) ($request->ip() ?? '0.0.0.0');
    }
}
