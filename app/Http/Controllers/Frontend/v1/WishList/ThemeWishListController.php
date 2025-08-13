<?php

namespace App\Http\Controllers\Frontend\v1\WishList;

use App\Enums\PageTypes;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\AddToWishListDataMapper;
use App\Http\Requests\Theme\WishList\WishListRequest;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
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

        return view('frontend.v1.pages.wishlist.index', compact([
            'themeBrands',
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
                'msg' => __('theme.add-to-wishlist-with-success')
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

            $wishList = app('wishlist');
            $wishList->remove($wishListData->productId);

            $wishListCount = $wishList->getContent()->count();

            return response()->json([
                'status' => true,
                'wishlist_count' => $wishListCount,
                'msg' => __('theme.delete-from-wishlist-with-success')
            ], ResponseAlias::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'msg' => __('theme.add-to-wishlist-with-error')
        ]);
    }
}
