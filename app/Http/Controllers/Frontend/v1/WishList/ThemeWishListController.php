<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\WishList;

use App\Enums\PageTypes;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\AddToWishListDataMapper;
use App\Http\Requests\Theme\WishList\WishListRequest;
use App\Models\Product;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Product\ThemeProductManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

final class ThemeWishListController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly AddToWishListDataMapper $addToWishListDataMapper,
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    ) {
    }

    public function index()
    {
        $themeBrands = $this->brandRepository->getLimited();

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getWishListType(), app()->getLocale());
        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));
            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());
            SEOMeta::setKeywords($seoKeywords);
            $this->seo()->opengraph()->setUrl(route('theme.wishlist.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        $wishList = app('wishlist');
        $ga4ViewWishlist = [
            'wishlist_item_count' => $wishList->getContent()->count(),
        ];

        return view('frontend.v1.pages.wishlist.index', compact([
            'themeBrands',
            'ga4ViewWishlist',
        ]));
    }

    public function addToWishList(WishListRequest $request)
    {
        if ($request->ajax()) {
            $wishListData = $this->addToWishListDataMapper->mapFromRequestToNormalized($request);

            $existedProduct = $this->productRepository->getById($wishListData->productId);

            if ($existedProduct === null)
            {
                throw new ProductNotFoundValidationException();
            }

            $price = $existedProduct->price;

            if ($existedProduct->sale_price !== '')
            {
                $price = $existedProduct->sale_price;
            }

            $wishList = app('wishlist');

            $wishList->add(
                $existedProduct->id,
                $existedProduct->title,
                $price,
                1,
                array(),
                $existedProduct
            );

            $wishListCount = $wishList->getContent()->count();

            return response()->json([
                'status' => true,
                'wishlist_count' => $wishListCount,
                'msg' => __('theme.add-to-wishlist-with-success'),
                (string) config('analytics.json_payload_keys.wishlist_line_item_added') => $this->buildGa4WishlistEcommercePayload($existedProduct),
            ], ResponseAlias::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'msg' => __('theme.add-to-wishlist-with-error')
        ]);


    }

    public function deleteFromWishList(WishListRequest $request)
    {
        if ($request->ajax()) {
            $wishListData = $this->addToWishListDataMapper->mapFromRequestToNormalized($request);

            $existedProduct = $this->productRepository->getById($wishListData->productId);
            $ga4Remove = null;
            if ($existedProduct !== null) {
                $ga4Remove = $this->buildGa4WishlistEcommercePayload($existedProduct);
            }

            $wishList = app('wishlist');
            $wishList->remove($wishListData->productId);

            $wishListCount = $wishList->getContent()->count();

            $json = [
                'status' => true,
                'wishlist_count' => $wishListCount,
                'msg' => __('theme.delete-from-wishlist-with-success'),
            ];
            if ($ga4Remove !== null) {
                $json[(string) config('analytics.json_payload_keys.wishlist_line_item_removed')] = $ga4Remove;
            }

            return response()->json($json, ResponseAlias::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'msg' => __('theme.add-to-wishlist-with-error')
        ]);
    }

    /**
     * @return array{currency: string, value: float, items: list<array<string, mixed>>}
     */
    private function buildGa4WishlistEcommercePayload(Product $product): array
    {
        $price = (float) ThemeProductManager::getProductTotalSum($product);

        return [
            'currency' => (string) config('analytics.currency', 'MDL'),
            'value' => $price,
            'items' => [[
                'item_id' => (string) ($product->onec_id ?? $product->id),
                'item_name' => $this->productDisplayName($product),
                'price' => $price,
                'quantity' => 1,
            ]],
        ];
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
