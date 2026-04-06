<?php

declare(strict_types=1);

namespace App\Jobs\Seo;

use App\Enums\PageTypes;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use App\Services\Seo\GeminiSeoGeneratorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class GenerateSeoMetaForItemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 0 = unlimited tries (retryUntil controls lifetime).
     */
    public int $tries = 0;

    /**
     * Keep retrying for up to 7 days so bulk generation always completes.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addDays(7);
    }

    /**
     * Progressive backoff: 1 min → 5 min → 6 hours (repeated).
     * On rate-limit we release manually with 6-hour delay.
     */
    public function backoff(): array
    {
        return [60, 300, 21_600];
    }

    public function __construct(
        private readonly string $pageType,
        private readonly ?string $pageId,
        private readonly string $locale,
        private readonly bool $force = false,
    ) {
    }

    public function handle(GeminiSeoGeneratorService $generator, PageTypes $pageTypes): void
    {
        if (!$this->force) {
            $exists = SeoMeta::where('page_type', $this->pageType)
                ->where('page_id', $this->pageId)
                ->where('locale', $this->locale)
                ->exists();

            if ($exists) {
                return;
            }
        }

        try {
            $seoData = $this->buildSeoData($generator, $pageTypes);
        } catch (\Throwable $e) {
            if ($this->isRateLimitError($e)) {
                $backoff = (int) config('gemini.rate_limit_backoff', 6 * 3600);
                Log::warning('GenerateSeoMetaForItemJob: Rate limit hit, releasing for ' . ($backoff / 3600) . 'h', [
                    'page_type' => $this->pageType,
                    'page_id'   => $this->pageId,
                    'locale'    => $this->locale,
                    'attempt'   => $this->attempts(),
                ]);
                $this->release($backoff);
                return;
            }

            Log::error('GenerateSeoMetaForItemJob: Unrecoverable error', [
                'page_type' => $this->pageType,
                'page_id'   => $this->pageId,
                'locale'    => $this->locale,
                'error'     => $e->getMessage(),
            ]);
            $this->fail($e);
            return;
        }

        if (empty(array_filter($seoData))) {
            Log::warning('GenerateSeoMetaForItemJob: Empty SEO data, skipping', [
                'page_type' => $this->pageType,
                'page_id'   => $this->pageId,
                'locale'    => $this->locale,
            ]);
            return;
        }

        SeoMeta::updateOrCreate(
            [
                'page_type' => $this->pageType,
                'page_id'   => $this->pageId,
                'locale'    => $this->locale,
            ],
            array_merge($seoData, ['ai_generated' => true])
        );
    }

    /**
     * Detect Gemini API rate-limit / quota errors.
     * Covers HTTP 429, 503 and quota-exceeded messages.
     */
    private function isRateLimitError(\Throwable $e): bool
    {
        $message = strtolower($e->getMessage());

        // Guzzle HTTP status codes
        if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
            $status = $e->getResponse()->getStatusCode();
            if (in_array($status, [429, 503])) {
                return true;
            }
        }

        // Keyword match for various Gemini SDK error formats
        foreach (['429', 'quota', 'rate limit', 'resource_exhausted', 'too many requests'] as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }

        return false;
    }

    private function buildSeoData(GeminiSeoGeneratorService $generator, PageTypes $pageTypes): array
    {
        return match ($this->pageType) {
            'product'  => $this->generateForProduct($generator),
            'category' => $this->generateForCategory($generator),
            'brand'    => $this->generateForBrand($generator),
            default    => $this->generateForStaticPage($generator, $pageTypes),
        };
    }

    private function generateForProduct(GeminiSeoGeneratorService $generator): array
    {
        $product = Product::with(['categories', 'brand', 'data'])
            ->where(function ($q) {
                $q->where('onec_id', $this->pageId)->orWhere('id', $this->pageId);
            })
            ->first();

        if (!$product) {
            Log::warning('GenerateSeoMetaForItemJob: Product not found', ['page_id' => $this->pageId]);
            return [];
        }

        return $generator->generateForProduct([
            'title'    => $product->getTranslation('title', $this->locale, false),
            'category' => $product->categories->first()?->getTranslation('name', $this->locale, false) ?? '',
            'brand'    => $product->brand?->getTranslation('title', $this->locale, false) ?? '',
            'summary'  => $product->data ? strip_tags((string)$product->data->getTranslation('summary', $this->locale, false)) : '',
        ], $this->locale);
    }

    private function generateForCategory(GeminiSeoGeneratorService $generator): array
    {
        $category = Category::with('parent')->where('onec_id', $this->pageId)->first();

        if (!$category) {
            Log::warning('GenerateSeoMetaForItemJob: Category not found', ['page_id' => $this->pageId]);
            return [];
        }

        return $generator->generateForCategory([
            'name'    => $category->getTranslation('name', $this->locale, false),
            'parent'  => $category->parent?->getTranslation('name', $this->locale, false) ?? '',
            'summary' => strip_tags((string)$category->getTranslation('summary', $this->locale, false)),
        ], $this->locale);
    }

    private function generateForBrand(GeminiSeoGeneratorService $generator): array
    {
        $brand = Brand::where('onec_id', $this->pageId)->first();

        if (!$brand) {
            Log::warning('GenerateSeoMetaForItemJob: Brand not found', ['page_id' => $this->pageId]);
            return [];
        }

        return $generator->generateForBrand([
            'name'        => $brand->getTranslation('title', $this->locale, false),
            'description' => strip_tags((string)$brand->getTranslation('description', $this->locale, false)),
        ], $this->locale);
    }

    private function generateForStaticPage(GeminiSeoGeneratorService $generator, PageTypes $pageTypes): array
    {
        $allTypes = $pageTypes->getAll();
        return $generator->generateForStaticPage($this->pageType, $allTypes[$this->pageType] ?? $this->pageType, $this->locale);
    }
}
