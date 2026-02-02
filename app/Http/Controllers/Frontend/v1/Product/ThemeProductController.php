<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Product;

use App\Enums\PageTypes;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\AddToCartDataMapper;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Category\ThemeCategoryManager;
use App\Services\Theme\Product\ThemeProductManager;
use App\Services\ViewCount\ViewCountManager;
use Artesaos\SEOTools\Facades\SEOMeta;
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

        $seo = $this->seoMetaRepository->get($this->pageTypes->getProductType(), (string)($product->onec_id ?? $product->id), app()->getLocale());
        $this->seo()->setTitle($seo->title ?? $product->title);
        if (!empty($seo?->description) && $seo?->description !== null) {
            $this->seo()->setDescription($seo?->description ? $seo?->description : trans('seo.description', [], app()->getLocale()));

        } else {
            $this->seo()->setDescription(strip_tags((string)$product?->data?->summary) ? strip_tags((string)$product?->data?->summary) : trans('seo.description', [], app()->getLocale()));
        }

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

        (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

        SEOMeta::setKeywords($seoKeywords);
        $this->seo()->opengraph()->setUrl(route('theme.product.index', $product->slug));
        $this->seo()->opengraph()->addProperty('type', 'product');
        $this->seo()->jsonLd()->setType('Product');

        //$this->viewCountManager->incrementProductViewCount($product, $request);

        return view('frontend.v1.pages.product.index-v2', compact([
            'product',
            'similarProducts',
            'breadcrumbs',
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

        //$this->viewCountManager->incrementProductViewCount($product, $request);

        $renderedView = view('frontend.v1.pages.product.quick-view-v2', compact(['product', 'similarProducts']))->render();

        return response()->json($renderedView);
    }
}
