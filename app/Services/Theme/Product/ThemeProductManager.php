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
use Illuminate\Support\Facades\Auth;

final class ThemeProductManager
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
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
//        if (Auth::guard('user')->user() === null || Auth::guard('user')->user()->type->key_name !== 'iur'){
//            $response['msg'] = __('theme.add_to_cart_not_permitted');
//            $response['status'] = 'not_permitted';
//
//            return $response;
//        }

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

        $price = $this->getProductPriceForCart($existedProduct);

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
                $response['msg'] = __('theme.product_not_in_stock_for_buy');
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
            $response['total'] = number_format(\Cart::session($sessionId)->getSubTotal(), 2, ',', '');
            $response['cart_count'] = $this->getProductCartCountPlural($sessionId);
            $response['msg']= __('theme.add_to_cart_product_item') . ' ' . $existedProduct->title . ' ' . __('theme.add-to-cart-with-success');
            $response['product_quantity'] = \Cart::session($sessionId)->get($productId)->quantity;

            if ($request->ajax()){
                $cart = view('frontend.v1.components.mini-cart')->render();
                $response['cart'] = $cart;
                $cart_page = view('frontend.v1.components.cart-table')->render();
                $response['cart-page'] = $cart_page;
                $response['in-cart'] = view('frontend.v1.components.product-card-summary-in-cart', ['product' => $existedProduct])->render();
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

    private function updateInstance(Product $existedProduct, $productQty, $price, $sessionId)
    {
        return \Cart::session($sessionId)->update(
            $existedProduct->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $productQty
                ),
            )
        );
    }

    public function updateCart(AddToCartData $addToCartData, AddToCartRequest $request): array
    {
//        if (Auth::guard('user')->user() === null || Auth::guard('user')->user()->type->key_name !== 'iur'){
//            $response['msg'] = __('theme.add_to_cart_not_permitted');
//            $response['status'] = 'not_permitted';
//
//            return $response;
//        }

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

        $price = $this->getProductPriceForCart($existedProduct);

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
                $response['msg'] = __('theme.product_not_in_stock_for_buy');
                $response['status'] = 'not_in_stock';
                $result = false;
            } else
            {
                $result = $this->updateInstance($existedProduct,$productQty,$price, $sessionId);
            }
        } else {
            $result = $this->updateInstance($existedProduct,$productQty,$price, $sessionId);
        }

        if ($result)
        {
            $response['status'] = true;
            $response['product_id'] = $productId;
            $response['product_title'] = $existedProduct->title;
            $response['total'] = number_format(\Cart::session($sessionId)->getSubTotal(), 2, ',', '');
            $response['cart_count'] = $this->getProductCartCountPlural($sessionId);
            $response['msg']= __('theme.order-product') . ' ' . $existedProduct->title . ' ' . __('theme.add-to-cart-with-success');
            $response['product_quantity'] = \Cart::session($sessionId)->get($productId)->quantity;

            if ($request->ajax()){
                $cart = view('frontend.v1.components.mini-cart')->render();
                $response['cart'] = $cart;
                $cart_page = view('frontend.v1.components.cart-table')->render();
                $response['cart-page'] = $cart_page;
            }
        }

        return $response;
    }

    public function deleteCartItem(string $productId, Request $request): array
    {
//        if (Auth::guard('user')->user() === null || Auth::guard('user')->user()->type->key_name !== 'iur'){
//            $response['msg'] = __('theme.add_to_cart_not_permitted');
//            $response['status'] = 'not_permitted';
//
//            return $response;
//        }

        $sessionId = config('shopping_cart.default_session_id');

        if (auth()->guard('user')->user()) {
            $sessionId = auth()->guard('user')->user()->id;
        }

        \Cart::session($sessionId)->remove($productId);

        $response['status'] = true;
        $response['total'] = number_format(\Cart::session($sessionId)->getSubTotal(), 2, ',', '');
        $response['cart_count'] = $this->getProductCartCountPlural($sessionId);
        $response['msg']= __('theme.product_was_deleted_successfully');

        if ($request->ajax())
        {
            $cart = view('frontend.v1.components.mini-cart')->render();
            $response['cart'] = $cart;
            $cart_page = view('frontend.v1.components.cart-table')->render();
            $response['cart-page'] = $cart_page;
        }

        return $response;
    }

    private function getProductCartCountPlural($sessionId)
    {
        return \Cart::session($sessionId)->getContent()->count();
    }

    public static function getProductTotalSum($product)
    {
        $user = Auth::guard('user')->user();
        $price = (float)$product->price;
        $priceKoef = (float)$product->price_koef;

        if ($user !== null && $user->with_sale) {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price - $price * ($user->sale / 100), 2, '.', '');
            } elseif($product->sale_price !== '' || $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, '.', '');
            }
            else{
                $price = number_format($price, 2, '.', '');
            }
        } else {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price * $priceKoef - $price * $priceKoef * ($user->sale / 100), 2, '.', '');
            } elseif($product->sale_price !== '' || $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, '.', '');
            }
            else{
                $price = number_format($price * $priceKoef, 2, '.', '');
            }
        }

        return $price;
    }

    public static function getProductSaleForLabel($product)
    {
        $user = Auth::guard('user')->user();
        $price = (float)$product->price;
        $priceKoef = (float)$product->price_koef;
        $productSale = $product->sale_price;

        if ($productSale === '' || $productSale === 0) {
            $productSale = 0;
        }

        if ($user !== null && $user->with_sale) {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = $price - $price * ($user->sale / 100);
            }
        } else {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = $price * $priceKoef - $price * $priceKoef * ($user->sale / 100);
            } else{
                $price = $price * $priceKoef;
            }
        }

        return round((($price - $productSale) / $price) * 100);
    }

    public static function getProductTotalSumWithReplace($product)
    {
        $user = Auth::guard('user')->user();
        $price = (float)$product->price;
        $priceKoef = (float)$product->price_koef;

        if ($user !== null && $user->with_sale) {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price - $price * ($user->sale / 100), 2, ',', '');
            } elseif($product->sale_price !== '' || $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, ',', '');
            }
            else{
                $price = number_format($price, 2, ',', '');
            }
        } else {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price * $priceKoef - $price * $priceKoef * ($user->sale / 100), 2, ',', '');
            } elseif($product->sale_price !== '' || $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, ',', '');
            }
            else{
                $price = number_format($price * $priceKoef, 2, ',', '');
            }
        }

        return $price;
    }

    private function getProductPriceForCart(Product $product)
    {
        $user = Auth::guard('user')->user();
        $price = (float)$product->price;
        $priceKoef = (float)$product->price_koef;

        if ($user !== null && $user->with_sale) {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price - $price * ($user->sale / 100), 2, '.', '');
            } elseif($product->sale_price !== '' || $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, '.', '');
            }
            else{
                $price = number_format($price, 2, '.', '');
            }
        } else {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price * $priceKoef - $price * $priceKoef * ($user->sale / 100), 2, '.', '');
            } elseif($product->sale_price !== '' || $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, '.', '');
            }
            else{
                $price = number_format($price * $priceKoef, 2, '.', '');
            }
        }

        return $price;
    }

}
