<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Dashboard;

use App\Enums\PageTypes;
use App\Http\Controllers\Controller;
use App\Jobs\Seo\GenerateSeoMetaForItemJob;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SeoMeta;
use App\Services\Seo\Contracts\SeoGeneratorContract;
use App\Services\Seo\SeoGeneratorFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class SeoGenerationController extends Controller
{
    private const LOCALES = ['ru', 'ro'];

    public function __construct(
        private readonly PageTypes $pageTypes,
        private readonly SeoGeneratorFactory $generatorFactory,
    ) {
    }

    /**
     * Get statistics: how many items have SEO vs total.
     */
    public function stats(): JsonResponse
    {
        $stats = [];

        foreach (self::LOCALES as $locale) {
            $productTotal = Product::where('site_status', 1)->count();
            $productWithSeo = SeoMeta::where('page_type', 'product')->where('locale', $locale)->count();

            $categoryTotal = Category::where('status', 1)->count();
            $categoryWithSeo = SeoMeta::where('page_type', 'category')->where('locale', $locale)->count();

            $brandTotal = Brand::where('status', 1)->count();
            $brandWithSeo = SeoMeta::where('page_type', 'brand')->where('locale', $locale)->count();

            $staticPages = $this->pageTypes->getStaticPages();
            $staticTotal = count($staticPages);
            $staticWithSeo = SeoMeta::whereIn('page_type', array_keys($staticPages))
                ->whereNull('page_id')
                ->where('locale', $locale)
                ->count();

            $stats[$locale] = [
                'products'      => ['total' => $productTotal, 'with_seo' => $productWithSeo, 'missing' => max(0, $productTotal - $productWithSeo)],
                'categories'    => ['total' => $categoryTotal, 'with_seo' => $categoryWithSeo, 'missing' => max(0, $categoryTotal - $categoryWithSeo)],
                'brands'        => ['total' => $brandTotal, 'with_seo' => $brandWithSeo, 'missing' => max(0, $brandTotal - $brandWithSeo)],
                'static_pages'  => ['total' => $staticTotal, 'with_seo' => $staticWithSeo, 'missing' => max(0, $staticTotal - $staticWithSeo)],
            ];
        }

        return response()->json(['status' => true, 'data' => $stats]);
    }

    /**
     * Return count of pending/delayed SEO generation jobs in the queue.
     * Works with the database queue driver; returns 0 for other drivers.
     */
    public function jobStatus(): JsonResponse
    {
        $pending  = 0;
        $delayed  = 0;
        $nextRetry = null;

        try {
            $jobClass = addslashes(GenerateSeoMetaForItemJob::class);

            $rows = DB::table('jobs')
                ->where('payload', 'like', '%' . $jobClass . '%')
                ->get(['available_at', 'attempts']);

            $now = now()->timestamp;

            foreach ($rows as $row) {
                if ($row->available_at <= $now) {
                    $pending++;
                } else {
                    $delayed++;
                    if ($nextRetry === null || $row->available_at < $nextRetry) {
                        $nextRetry = $row->available_at;
                    }
                }
            }
        } catch (\Throwable) {
            // jobs table may not exist (non-database queue driver)
        }

        $total = $pending + $delayed;

        return response()->json([
            'total'      => $total,
            'pending'    => $pending,
            'delayed'    => $delayed,
            'next_retry' => $nextRetry ? date('H:i d.m.Y', $nextRetry) : null,
            'active'     => $total > 0,
        ]);
    }

    /**
     * Dispatch bulk generation jobs for a given type and locale.
     */
    public function generateBulk(Request $request): JsonResponse
    {
        $request->validate([
            'type'     => 'required|string|in:products,categories,brands,static_pages',
            'locale'   => 'required|string|in:ru,ro',
            'force'    => 'nullable|boolean',
            'provider' => 'nullable|string|in:gemini,claude',
        ]);

        $type     = $request->get('type');
        $locale   = $request->get('locale');
        $force    = $request->boolean('force', false);
        $provider = $this->generatorFactory->normalize($request->get('provider'));

        $dispatched = match ($type) {
            'products'     => $this->dispatchForProducts($locale, $force, $provider),
            'categories'   => $this->dispatchForCategories($locale, $force, $provider),
            'brands'       => $this->dispatchForBrands($locale, $force, $provider),
            'static_pages' => $this->dispatchForStaticPages($locale, $force, $provider),
        };

        $providerLabel = (string) config("seo_ai.labels.{$provider}", ucfirst($provider));

        return response()->json([
            'status'     => true,
            'dispatched' => $dispatched,
            'message'    => "Запущено {$dispatched} задач генерации SEO ({$providerLabel}) для {$locale}",
        ]);
    }

    /**
     * Generate SEO for a single item synchronously (used on edit page).
     */
    public function generateSingle(Request $request): JsonResponse
    {
        $request->validate([
            'page_type' => 'required|string',
            'page_id'   => 'nullable|string',
            'locale'    => 'required|string|in:ru,ro',
            'provider'  => 'nullable|string|in:gemini,claude',
        ]);

        $pageType = $request->get('page_type');
        $pageId   = $request->get('page_id');
        $locale   = $request->get('locale');
        $provider = $this->generatorFactory->normalize($request->get('provider'));

        try {
            $generator = $this->generatorFactory->make($provider);
            $seoData   = $this->generateSingleData($generator, $pageType, $pageId, $locale);

            return response()->json(['status' => true, 'data' => $seoData]);
        } catch (\Throwable $e) {
            if ($this->isQuotaError($e)) {
                return response()->json([
                    'status'    => false,
                    'quota'     => true,
                    'message'   => $this->friendlyQuotaMessage($e, $provider),
                ], 429);
            }
            return response()->json(['status' => false, 'message' => 'Ошибка генерации: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Regenerate and save SEO for an existing SeoMeta record.
     */
    public function regenerate(Request $request, SeoMeta $seoMeta): JsonResponse
    {
        $request->validate([
            'provider' => 'nullable|string|in:gemini,claude',
        ]);
        $provider = $this->generatorFactory->normalize($request->get('provider'));

        try {
            $generator = $this->generatorFactory->make($provider);
            $seoData   = $this->generateSingleData(
                $generator,
                $seoMeta->page_type,
                $seoMeta->page_id !== null ? (string) $seoMeta->page_id : null,
                $seoMeta->locale
            );

            if (empty(array_filter($seoData))) {
                return response()->json(['status' => false, 'message' => 'Не удалось сгенерировать SEO данные'], 422);
            }

            $seoMeta->update(array_merge($seoData, ['ai_generated' => true]));

            return response()->json([
                'status'  => true,
                'message' => 'SEO успешно регенерирован',
                'data'    => $seoData,
            ]);
        } catch (\Throwable $e) {
            if ($this->isQuotaError($e)) {
                return response()->json([
                    'status'  => false,
                    'quota'   => true,
                    'message' => $this->friendlyQuotaMessage($e, $provider),
                ], 429);
            }
            return response()->json(['status' => false, 'message' => 'Ошибка регенерации: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Detect quota / rate-limit errors from Gemini API.
     */
    private function isQuotaError(\Throwable $e): bool
    {
        $msg = strtolower($e->getMessage());
        foreach (['429', 'quota', 'rate limit', 'resource_exhausted', 'too many requests', 'exceeded your current quota'] as $kw) {
            if (str_contains($msg, $kw)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Build a user-friendly quota error message, extracting retry-after seconds if present.
     */
    private function friendlyQuotaMessage(\Throwable $e, string $provider = 'gemini'): string
    {
        $raw   = $e->getMessage();
        $label = (string) config("seo_ai.labels.{$provider}", ucfirst($provider));

        // Extract "Please retry in X.Xs"
        if (preg_match('/please retry in ([\d.]+)s/i', $raw, $m)) {
            $seconds = (int) ceil((float) $m[1]);
            $wait    = $seconds >= 60
                ? round($seconds / 60, 1) . ' мин.'
                : $seconds . ' сек.';
            return "Превышен лимит {$label} API. Повторите через {$wait}.";
        }

        // Billing / free-tier exhausted (limit: 0)
        if (str_contains($raw, 'limit: 0')) {
            return "Исчерпан бесплатный лимит {$label} API. Включите биллинг или подождите сброса квоты.";
        }

        return "Превышен лимит {$label} API. Попробуйте позже.";
    }

    private function generateSingleData(SeoGeneratorContract $generator, string $pageType, ?string $pageId, string $locale): array
    {
        return match ($pageType) {
            'product'  => $this->buildProductData($generator, $pageId, $locale),
            'category' => $this->buildCategoryData($generator, $pageId, $locale),
            'brand'    => $this->buildBrandData($generator, $pageId, $locale),
            default    => $this->buildStaticPageData($generator, $pageType, $locale),
        };
    }

    private function buildProductData(SeoGeneratorContract $generator, ?string $pageId, string $locale): array
    {
        $product = Product::with(['categories', 'brand', 'data'])
            ->where(function ($q) use ($pageId) {
                $q->where('onec_id', $pageId)->orWhere('id', $pageId);
            })
            ->first();

        if (!$product) {
            throw new \RuntimeException("Товар с ID {$pageId} не найден");
        }

        return $generator->generateForProduct([
            'title'    => $product->getTranslation('title', $locale, false),
            'category' => $product->categories->first()?->getTranslation('name', $locale, false) ?? '',
            'brand'    => $product->brand?->getTranslation('title', $locale, false) ?? '',
            'summary'  => $product->data ? strip_tags((string)$product->data->getTranslation('summary', $locale, false)) : '',
        ], $locale);
    }

    private function buildCategoryData(SeoGeneratorContract $generator, ?string $pageId, string $locale): array
    {
        $category = Category::with('parent')->where('onec_id', $pageId)->first();

        if (!$category) {
            throw new \RuntimeException("Категория с ID {$pageId} не найдена");
        }

        return $generator->generateForCategory([
            'name'    => $category->getTranslation('name', $locale, false),
            'parent'  => $category->parent?->getTranslation('name', $locale, false) ?? '',
            'summary' => strip_tags((string)$category->getTranslation('summary', $locale, false)),
        ], $locale);
    }

    private function buildBrandData(SeoGeneratorContract $generator, ?string $pageId, string $locale): array
    {
        $brand = Brand::where('onec_id', $pageId)->first();

        if (!$brand) {
            throw new \RuntimeException("Бренд с ID {$pageId} не найден");
        }

        return $generator->generateForBrand([
            'name'        => $brand->getTranslation('title', $locale, false),
            'description' => strip_tags((string)$brand->getTranslation('description', $locale, false)),
        ], $locale);
    }

    private function buildStaticPageData(SeoGeneratorContract $generator, string $pageType, string $locale): array
    {
        $allTypes = $this->pageTypes->getAll();
        $label    = $allTypes[$pageType] ?? $pageType;

        return $generator->generateForStaticPage($pageType, $label, $locale);
    }

    private function dispatchForProducts(string $locale, bool $force, string $provider): int
    {
        $count = 0;
        $ids   = [];

        Product::where('site_status', 1)
            ->select(['id', 'onec_id'])
            ->chunk(200, function ($products) use (&$ids) {
                foreach ($products as $p) {
                    $ids[] = (string)($p->onec_id ?? $p->id);
                }
            });

        foreach ($ids as $index => $pageId) {
            GenerateSeoMetaForItemJob::dispatch('product', $pageId, $locale, $force, $provider)
                ->delay(now()->addSeconds($this->jobDelay($index, $provider)));
            $count++;
        }

        return $count;
    }

    private function dispatchForCategories(string $locale, bool $force, string $provider): int
    {
        $count = 0;
        $ids   = [];

        Category::where('status', 1)
            ->select(['id', 'onec_id'])
            ->chunk(200, function ($categories) use (&$ids) {
                foreach ($categories as $c) {
                    $ids[] = (string)$c->onec_id;
                }
            });

        foreach ($ids as $index => $pageId) {
            GenerateSeoMetaForItemJob::dispatch('category', $pageId, $locale, $force, $provider)
                ->delay(now()->addSeconds($this->jobDelay($index, $provider)));
            $count++;
        }

        return $count;
    }

    private function dispatchForBrands(string $locale, bool $force, string $provider): int
    {
        $count = 0;
        $ids   = [];

        Brand::where('status', 1)
            ->select(['id', 'onec_id'])
            ->chunk(200, function ($brands) use (&$ids) {
                foreach ($brands as $b) {
                    $ids[] = (string)$b->onec_id;
                }
            });

        foreach ($ids as $index => $pageId) {
            GenerateSeoMetaForItemJob::dispatch('brand', $pageId, $locale, $force, $provider)
                ->delay(now()->addSeconds($this->jobDelay($index, $provider)));
            $count++;
        }

        return $count;
    }

    private function dispatchForStaticPages(string $locale, bool $force, string $provider): int
    {
        $staticPages = $this->pageTypes->getStaticPages();
        $index       = 0;

        foreach ($staticPages as $pageType => $label) {
            GenerateSeoMetaForItemJob::dispatch($pageType, null, $locale, $force, $provider)
                ->delay(now()->addSeconds($this->jobDelay($index, $provider)));
            $index++;
        }

        return count($staticPages);
    }

    /**
     * Calculate dispatch delay (seconds) for job at position $index.
     *
     * Respects two free-tier limits:
     *  - RPM: space requests by (60 / rpm_limit) seconds within each day-slot
     *  - RPD: after rpd_limit jobs, shift to the next day
     *
     * Example with rpm=4, rpd=18:
     *   index 0  → 0s      (day 0, slot 0)
     *   index 1  → 15s     (day 0, slot 1)
     *   index 17 → 255s    (day 0, slot 17) — last of day 0
     *   index 18 → 86400s  (day 1, slot 0)
     *   index 19 → 86415s  (day 1, slot 1)  etc.
     */
    private function jobDelay(int $index, string $provider = 'gemini'): int
    {
        $cfg          = $provider === SeoGeneratorFactory::PROVIDER_CLAUDE ? 'claude' : 'gemini';
        $rpm          = max(1, (int) config("{$cfg}.rpm_limit", 4));
        $rpd          = max(1, (int) config("{$cfg}.rpd_limit", 18));
        $secPerReq    = (int) ceil(60 / $rpm);   // 15s for rpm=4

        $day          = (int) floor($index / $rpd);
        $slotInDay    = $index % $rpd;

        return $day * 86400 + $slotInDay * $secPerReq;
    }
}
