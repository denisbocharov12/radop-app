<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Product;

use App\Enums\PageTypes;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\AddToCartDataMapper;
use App\Models\Product;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Category\ThemeCategoryManager;
use App\Services\Seo\ProductSchemaOrgBuilder;
use App\Services\Seo\SeoFallbackGenerator;
use App\Services\Theme\Product\ThemeProductManager;
use App\Services\ViewCount\ViewCountManager;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;

final class ThemeProductController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly ThemeProductManager $themeProductManager,
        private readonly ProductRepository $productRepository,
        private readonly AddToCartDataMapper $addToCartDataMapper,
        private readonly ThemeCategoryManager $themeCategoryManager,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
        private readonly ViewCountManager $viewCountManager,
        private readonly ProductSchemaOrgBuilder $productSchemaOrgBuilder,
        private readonly SeoFallbackGenerator $seoFallback,
    ) {
    }

    public function index(Request $request, string $slug)
    {
        $similarProducts = null;
        $breadcrumbs = null;

        $product = $this->productRepository->getBySlug($slug);

        if ($product === null) {
            throw new ProductNotFoundValidationException();
        }

        if (!$product->categories->isEmpty()) {
            $similarProducts = $this->productRepository->getAllSimilarProducts($product);
        }
        if (!$product->categories->isEmpty()) {
            $breadcrumbs = $this->themeCategoryManager->getBreadcrumbsForCategory($product->categories->first());
        }

        $locale = app()->getLocale();
        $seo = $this->seoMetaRepository->get($this->pageTypes->getProductType(), (string)($product->onec_id ?? $product->id), $locale);

        $seoTitle = ($seo?->title !== null && $seo->title !== '')
            ? $seo->title
            : $this->seoFallback->productTitle($product, $locale);

        $productSummary = strip_tags((string) $product?->data?->summary);
        $seoDescription = ($seo?->description !== null && $seo->description !== '')
            ? $seo->description
            : ($productSummary !== '' ? $this->seoFallback->clipDescription($productSummary) : $this->seoFallback->productDescription($product, $locale));

        $this->seo()->setTitle($seoTitle);
        // Search engines truncate snippets at about 160 characters; clip manual (admin) texts too.
        $seoDescription = $this->seoFallback->clipDescription((string) $seoDescription);
        $this->seo()->setDescription($seoDescription);

        $imageUrl = config('seotools.meta.defaults.default_image');

        if ($seo !== null) {
            if ($seo->hasMedia('files')) {
                $imageUrl = $seo->getFirstMediaUrl('files');
            } else {
                $imageUrl = $product->getFirstMediaUrl('products') ?: config('seotools.meta.defaults.default_image');
            }
        } else {
            if ($product->hasMedia('products')) {
                $imageUrl = $product->getFirstMediaUrl('products');
            }
        }

        $this->seo()->addImages($imageUrl);

        $this->seo()->opengraph()->setUrl(route('theme.product.index', $product->slug));
        $this->seo()->opengraph()->addProperty('type', 'product');
        $this->seo()->jsonLd()->setType('Product');
        $this->seo()->jsonLd()->setTitle($seoTitle);
        $this->seo()->jsonLd()->setDescription($seoDescription);
        $this->seo()->jsonLd()->setUrl(route('theme.product.index', $product->slug));
        $this->seo()->jsonLd()->addValues($this->productSchemaOrgBuilder->build($product));

        $this->viewCountManager->incrementProductViewCount($product, $request);

        $priceFloat = (float) ThemeProductManager::getProductTotalSum($product);
        $ga4ViewItem = [
            'currency' => (string) config('analytics.currency', 'MDL'),
            'value' => $priceFloat,
            'items' => [[
                'item_id' => (string) ($product->onec_id ?? $product->id),
                'item_name' => $this->productDisplayName($product),
                'price' => $priceFloat,
                'quantity' => 1,
            ]],
        ];

        return view('frontend.v1.pages.product.index-v2', compact([
            'product',
            'similarProducts',
            'breadcrumbs',
            'ga4ViewItem',
        ]));
    }

    public function addToCart(AddToCartRequest $request)
    {

        $addToCartData = $this->addToCartDataMapper->mapFromRequestToNormalized($request);

        try {
            $response = $this->themeProductManager->addToCart($addToCartData, $request);

            return response()->json($response);

        } catch (ProductNotFoundException) {
            throw new ProductNotFoundException();
        }
    }

    public function updateCart(AddToCartRequest $request)
    {

        $addToCartData = $this->addToCartDataMapper->mapFromRequestToNormalized($request);

        try {
            $response = $this->themeProductManager->updateCart($addToCartData, $request);

            return response()->json($response);

        } catch (ProductNotFoundException) {
            throw new ProductNotFoundException();
        }
    }

    public function deleteCartItem(Request $request)
    {
        try {
            $response = $this->themeProductManager->deleteCartItem($request->input('product_id'), $request);

            return response()->json($response);

        } catch (ProductNotFoundException) {
            throw new ProductNotFoundException();
        }
    }
    public function quickView(Request $request)
    {
        $productId = (int)$request->input('product_id');

        $product = $this->productRepository->getById($productId);

        if ($product === null) {
            throw new ProductNotFoundValidationException();
        }

        $similarProducts = null;

        if (!$product->categories->isEmpty()) {
            $similarProducts = $this->productRepository->getAllSimilarProducts($product);
        }

        // Quick-view (AJAX modal) intentionally does NOT count a view — the full
        // product page counts it, so counting here would double-count.

        $renderedView = view('frontend.v1.pages.product.quick-view-v2', compact(['product', 'similarProducts']))->render();

        return response()->json($renderedView);
    }

    private function productDisplayName(Product $product): string
    {
        $t = $product->getTranslation('title', app()->getLocale(), false);
        if (is_string($t) && $t !== '') {
            return strip_tags($t);
        }
        $raw = $product->title;
        if (is_string($raw)) {
            return strip_tags($raw);
        }

        return 'item';
    }
}
