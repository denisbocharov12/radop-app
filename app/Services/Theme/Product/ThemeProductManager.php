<?php

declare(strict_types=1);

namespace App\Services\Theme\Product;

use App\Data\Theme\Product\AddToCartData;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class ThemeProductManager
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function getBreadcrumbsForProduct(Product $product): ?Collection
    {
        $breadcrumbsCollection = collect();
        $breadcrumbsCollection->add($product->category);

        $parentCategory = $product->category->parent;

        while ($parentCategory !== null) {
            $breadcrumbsCollection->add($parentCategory);
            $parentCategory = $parentCategory->parent;
        }

        return $breadcrumbsCollection->reverse();
    }

    public function addToCart(AddToCartData $addToCartData, AddToCartRequest $request): array
    {

        $existedProduct = $this->productRepository->getById($addToCartData->productId);

        if ($existedProduct === null)
        {
            throw new ProductNotFoundException();
        }

        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $productId = $existedProduct->id;

        (int)$productQty = $addToCartData->productQty;

        $productStock = $existedProduct->stock;

        $price = $existedProduct->price;

        if ($existedProduct->sale_price !== '')
        {
            $price = $existedProduct->sale_price;
        }

        $cartArray = [];

        foreach (\Cart::session($sessionId)->getContent() as $item)
        {
            $cartArray[$item->id] = $item->id;
        }

        $productKey = array_search($productId, $cartArray);

        if (in_array($productId, $cartArray))
        {
            $exProduct = \Cart::session($sessionId)->get($productKey);

            if ($productStock < (int)$exProduct->qty + (int)$productQty)
            {
                $response['msg'] = 'У нас нет столько товара на складе';
                $response['status'] = 'not_in_stock';
                $result = false;
            } else
            {
                $result = $this->addToInstance($existedProduct,$productQty,$price, $sessionId);
            }
        } else {
            $result = $this->addToInstance($existedProduct,$productQty,$price, $sessionId);
        }

        if ($result)
        {
            $response['status'] = true;
            $response['product_id'] = $productId;
            $response['product_title'] = $existedProduct->title;
            $response['total'] = \Cart::session($sessionId)->getSubTotal();
            $response['cart_count'] = \Cart::session($sessionId)->getContent()->count();
            $response['msg']= 'Товар ' .$existedProduct->title. ' успешно добавлен в корзину';

            if ($request->ajax()){
                $cart = view('frontend.v1.components.mini-cart')->render();
                $response['cart'] = $cart;
                $cart_page = view('frontend.v1.components.cart-page')->render();
                $response['cart-page'] = $cart_page;
            }
        }

        return $response;
    }

    private function addToInstance(Product $existedProduct, $productQty, $price, $sessionId)
    {
        return \Cart::session($sessionId)->add(
            array(
                'id' => $existedProduct->id,
                'name' => $existedProduct->title,
                'price' => (float)$price,
                'quantity' => $productQty,
                'attributes' => array(),
                'associatedModel' => $existedProduct
            )
        );
    }

    public function updateCart(AddToCartData $addToCartData, AddToCartRequest $request): array
    {

        $existedProduct = $this->productRepository->getById($addToCartData->productId);

        if ($existedProduct === null)
        {
            throw new ProductNotFoundException();
        }

        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        $productId = $existedProduct->id;

        (int)$productQty = $addToCartData->productQty;

        $productStock = $existedProduct->stock;

        $price = $existedProduct->price;

        if ($existedProduct->sale_price !== '')
        {
            $price = $existedProduct->sale_price;
        }

        $cartArray = [];

        foreach (\Cart::session($sessionId)->getContent() as $item)
        {
            $cartArray[$item->id] = $item->id;
        }

        $productKey = array_search($productId, $cartArray);

        if (in_array($productId, $cartArray))
        {
            $exProduct = \Cart::session($sessionId)->get($productKey);

            if ($productStock < (int)$exProduct->qty + (int)$productQty)
            {
                $response['msg'] = 'У нас нет столько товара на складе';
                $response['status'] = 'not_in_stock';
                $result = false;
            } else
            {
                $result = $this->addToInstance($existedProduct,$productQty,$price, $sessionId);
            }
        } else {
            $result = $this->addToInstance($existedProduct,$productQty,$price, $sessionId);
        }

        if ($result)
        {
            $response['status'] = true;
            $response['product_id'] = $productId;
            $response['product_title'] = $existedProduct->title;
            $response['total'] = \Cart::session($sessionId)->getSubTotal();
            $response['cart_count'] = \Cart::session($sessionId)->getContent()->count();
            $response['msg']= 'Товар ' .$existedProduct->title. ' успешно добавлен в корзину';

            if ($request->ajax()){
                $cart = view('frontend.v1.components.mini-cart')->render();
                $response['cart'] = $cart;
                $cart_page = view('frontend.v1.components.cart-page')->render();
                $response['cart-page'] = $cart_page;
            }
        }

        return $response;
    }

    public function deleteCartItem(string $productId, Request $request): array
    {
        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        \Cart::session($sessionId)->remove($productId);

        $response['status'] = true;
        $response['total'] = \Cart::session($sessionId)->getSubTotal();
        $response['cart_count'] = \Cart::session($sessionId)->getContent()->count();
        $response['msg']= 'Товар успешно удален';

        if ($request->ajax())
        {
            $cart = view('frontend.v1.components.mini-cart')->render();
            $response['cart'] = $cart;
            $cart_page = view('frontend.v1.components.cart-page')->render();
            $response['cart-page'] = $cart_page;
        }

        return $response;
    }
}
