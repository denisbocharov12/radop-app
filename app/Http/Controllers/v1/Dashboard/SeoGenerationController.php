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
use App\Services\Seo\GeminiSeoGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class SeoGenerationController extends Controller
{
    private const LOCALES = ['ru', 'ro'];

    public function __construct(
        private readonly PageTypes $pageTypes,
        private readonly GeminiSeoGeneratorService $geminiService,
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
            'type'   => 'required|string|in:products,categories,brands,static_pages',
            'locale' => 'required|string|in:ru,ro',
            'force'  => 'nullable|boolean',
        ]);

        $type   = $request->get('type');
        $locale = $request->get('locale');
        $force  = $request->boolean('force', false);

        $dispatched = match ($type) {
            'products'     => $this->dispatchForProducts($locale, $force),
            'categories'   => $this->dispatchForCategories($locale, $force),
            'brands'       => $this->dispatchForBrands($locale, $force),
            'static_pages' => $this->dispatchForStaticPages($locale, $force),
        };

        return response()->json([
            'status'     => true,
            'dispatched' => $dispatched,
            'message'    => "Запущено {$dispatched} задач генерации SEO для {$locale}",
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
        ]);

        $pageType = $request->get('page_type');
        $pageId   = $request->get('page_id');
        $locale   = $request->get('locale');

        try {
            $seoData = $this->generateSingleData($pageType, $pageId, $locale);

            return response()->json(['status' => true, 'data' => $seoData]);
        } catch (\Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Ошибка генерации: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Regenerate and save SEO for an existing SeoMeta record.
     */
    public function regenerate(SeoMeta $seoMeta): JsonResponse
    {
        try {
            $seoData = $this->generateSingleData($seoMeta->page_type, $seoMeta->page_id !== null ? (string) $seoMeta->page_id : null, $seoMeta->locale);

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
            return response()->json(['status' => false, 'message' => 'Ошибка регенерации: ' . $e->getMessage()], 500);
        }
    }

    private function generateSingleData(string $pageType, ?string $pageId, string $locale): array
    {
        return match ($pageType) {
            'product'  => $this->buildProductData($pageId, $locale),
            'category' => $this->buildCategoryData($pageId, $locale),
            'brand'    => $this->buildBrandData($pageId, $locale),
            default    => $this->buildStaticPageData($pageType, $locale),
        };
    }

    private function buildProductData(?string $pageId, string $locale): array
    {
        $product = Product::with(['categories', 'brand', 'data'])
            ->where(function ($q) use ($pageId) {
                $q->where('onec_id', $pageId)->orWhere('id', $pageId);
            })
            ->first();

        if (!$product) {
            throw new \RuntimeException("Товар с ID {$pageId} не найден");
        }

        return $this->geminiService->generateForProduct([
            'title'    => $product->getTranslation('title', $locale, false),
            'category' => $product->categories->first()?->getTranslation('name', $locale, false) ?? '',
            'brand'    => $product->brand?->getTranslation('title', $locale, false) ?? '',
            'summary'  => $product->data ? strip_tags((string)$product->data->getTranslation('summary', $locale, false)) : '',
        ], $locale);
    }

    private function buildCategoryData(?string $pageId, string $locale): array
    {
        $category = Category::with('parent')->where('onec_id', $pageId)->first();

        if (!$category) {
            throw new \RuntimeException("Категория с ID {$pageId} не найдена");
        }

        return $this->geminiService->generateForCategory([
            'name'    => $category->getTranslation('name', $locale, false),
            'parent'  => $category->parent?->getTranslation('name', $locale, false) ?? '',
            'summary' => strip_tags((string)$category->getTranslation('summary', $locale, false)),
        ], $locale);
    }

    private function buildBrandData(?string $pageId, string $locale): array
    {
        $brand = Brand::where('onec_id', $pageId)->first();

        if (!$brand) {
            throw new \RuntimeException("Бренд с ID {$pageId} не найден");
        }

        return $this->geminiService->generateForBrand([
            'name'        => $brand->getTranslation('title', $locale, false),
            'description' => strip_tags((string)$brand->getTranslation('description', $locale, false)),
        ], $locale);
    }

    private function buildStaticPageData(string $pageType, string $locale): array
    {
        $allTypes = $this->pageTypes->getAll();
        $label    = $allTypes[$pageType] ?? $pageType;

        return $this->geminiService->generateForStaticPage($pageType, $label, $locale);
    }

    private function dispatchForProducts(string $locale, bool $force): int
    {
        $count = 0;
        Product::where('site_status', 1)
            ->select(['id', 'onec_id'])
            ->chunk(100, function ($products) use ($locale, $force, &$count) {
                foreach ($products as $product) {
                    $pageId = (string)($product->onec_id ?? $product->id);
                    GenerateSeoMetaForItemJob::dispatch('product', $pageId, $locale, $force);
                    $count++;
                }
            });
        return $count;
    }

    private function dispatchForCategories(string $locale, bool $force): int
    {
        $count = 0;
        Category::where('status', 1)
            ->select(['id', 'onec_id'])
            ->chunk(100, function ($categories) use ($locale, $force, &$count) {
                foreach ($categories as $category) {
                    GenerateSeoMetaForItemJob::dispatch('category', (string)$category->onec_id, $locale, $force);
                    $count++;
                }
            });
        return $count;
    }

    private function dispatchForBrands(string $locale, bool $force): int
    {
        $count = 0;
        Brand::where('status', 1)
            ->select(['id', 'onec_id'])
            ->chunk(100, function ($brands) use ($locale, $force, &$count) {
                foreach ($brands as $brand) {
                    GenerateSeoMetaForItemJob::dispatch('brand', (string)$brand->onec_id, $locale, $force);
                    $count++;
                }
            });
        return $count;
    }

    private function dispatchForStaticPages(string $locale, bool $force): int
    {
        $staticPages = $this->pageTypes->getStaticPages();
        foreach ($staticPages as $pageType => $label) {
            GenerateSeoMetaForItemJob::dispatch($pageType, null, $locale, $force);
        }
        return count($staticPages);
    }
}
