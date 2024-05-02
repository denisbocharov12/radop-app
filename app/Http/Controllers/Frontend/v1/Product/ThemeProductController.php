<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Product;

use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotFoundValidationException;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Theme\AddToCartDataMapper;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Product\ThemeProductManager;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

final class ThemeProductController extends Controller
{
    public function __construct(
        private readonly ThemeProductManager $themeProductManager,
        private readonly ProductRepository $productRepository,
        private readonly AddToCartDataMapper $addToCartDataMapper,
    )
    {
    }

    public function index(Request $request, string $slug)
    {
        $product = $this->productRepository->getBySlug($slug);

        if ($product === null) {
            throw new ProductNotFoundValidationException();
        }

        return view('frontend.v1.pages.product.index', compact([
            'product',
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
}
