<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Product;

use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\AddToCartDataMapper;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Category\ThemeCategoryManager;
use App\Services\Theme\Product\ThemeProductManager;
use Illuminate\Http\Request;

final class ThemeProductController extends Controller
{
    public function __construct(
        private readonly ThemeProductManager $themeProductManager,
        private readonly ProductRepository $productRepository,
        private readonly AddToCartDataMapper $addToCartDataMapper,
        private readonly ThemeCategoryManager $themeCategoryManager,
    ) {
    }

    public function index(Request $request, string $slug)
    {
        $similarProducts = null;

        $product = $this->productRepository->getBySlug($slug);

        if ($product === null) {
            throw new ProductNotFoundValidationException();
        }

        if (!$product->categories->isEmpty()) {
            $similarProducts = $this->productRepository->getAllSimilarProducts($product);
        }

        $breadcrumbs = $this->themeCategoryManager->getBreadcrumbsForCategory($product->categories->first());

        return view('frontend.v1.pages.product.index', compact([
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
}
