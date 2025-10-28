<?php

declare(strict_types=1);

namespace App\Services\Theme\Product;

use App\Data\Theme\Product\AddToCartData;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Models\Product;
use App\Models\User;
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
        $productQty = (int)$addToCartData->productQty;
        $productStock = $existedProduct->stock;
        $price = $this->getProductPriceForCart($existedProduct);

        $cartProduct = \Cart::session($sessionId)->get($productId);
        $cartQty = $cartProduct ? (int)$cartProduct->quantity : 0;

        if ($cartQty >= $productStock) {
            $response['msg'] = $this->buildLimitedStockMessage($existedProduct->stock);
            $response['status'] = 'not_in_stock';
            return $response;
        }
        if ($productStock < $cartQty + $productQty) {
            $response['msg'] = $this->buildLimitedStockMessage($existedProduct->stock);
            $response['status'] = 'not_in_stock';
            return $response;
        }

        $result = $this->addToInstance($existedProduct, $productQty, $price, $sessionId);

        if ($result)
        {
            $response['status'] = true;
            $response['product_id'] = $productId;
            $response['product_title'] = $existedProduct->title;
            $response['total'] = number_format(\Cart::session($sessionId)->getSubTotal(), 2, ',', '');
            $response['cart_count'] = $this->getProductCartCountPlural($sessionId);
            $response['msg']= $existedProduct->title . ' ' . __('theme.add-to-cart-with-success');
            $response['product_quantity'] = \Cart::session($sessionId)->get($productId)->quantity;

            if ($request->ajax()){
                $cart = view('frontend.v1.components.mini-cart')->render();
                $response['cart'] = $cart;
                $cart_page = view('frontend.v1.components.cart-table')->render();
                $response['cart-page'] = $cart_page;
                $response['in-cart'] = view('frontend.v1.components.product-card-summary-in-cart-content', ['product' => $existedProduct])->render();
            }
        }

        return $response;
    }

    /**
     * @param Product $existedProduct
     * @param int $productQty
     * @param string $price
     * @param string|int $sessionId
     * @return mixed
     */
    private function addToInstance(Product $existedProduct, $productQty, $price, $sessionId)
    {
        $cartItem = \Cart::session($sessionId)->get($existedProduct->id);
        
        if ($cartItem) {
            $existingAddedAt = isset($cartItem->attributes['added_at']) 
                ? $cartItem->attributes['added_at'] 
                : now()->timestamp;
            
            $newQuantity = $cartItem->quantity + $productQty;
            
            \Cart::session($sessionId)->remove($existedProduct->id);
            
            return \Cart::session($sessionId)->add(
                array(
                    'id' => $existedProduct->id,
                    'name' => $existedProduct->title,
                    'price' => (float)$price,
                    'quantity' => $newQuantity,
                    'attributes' => array(
                        'added_at' => $existingAddedAt,
                    ),
                    'associatedModel' => $existedProduct
                )
            );
        }
        
        return \Cart::session($sessionId)->add(
            array(
                'id' => $existedProduct->id,
                'name' => $existedProduct->title,
                'price' => (float)$price,
                'quantity' => $productQty,
                'attributes' => array(
                    'added_at' => now()->timestamp,
                ),
                'associatedModel' => $existedProduct
            )
        );
    }

    /**
     * @param Product $existedProduct
     * @param int $productQty
     * @param string $price
     * @param string|int $sessionId
     * @return mixed
     */
    private function updateInstance(Product $existedProduct, $productQty, $price, $sessionId)
    {
        $cartItem = \Cart::session($sessionId)->get($existedProduct->id);
        $existingAddedAt = $cartItem && isset($cartItem->attributes['added_at']) 
            ? $cartItem->attributes['added_at'] 
            : now()->timestamp;
        
        \Cart::session($sessionId)->remove($existedProduct->id);
        
        return \Cart::session($sessionId)->add(
            array(
                'id' => $existedProduct->id,
                'name' => $existedProduct->title,
                'price' => (float)$price,
                'quantity' => $productQty,
                'attributes' => array(
                    'added_at' => $existingAddedAt,
                ),
                'associatedModel' => $existedProduct
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

        if ($existedProduct->min_order !== null && (int)$addToCartData->productQty < $existedProduct->min_order) {
            $response['msg'] = __('theme.min-order') . ' ' . $existedProduct->min_order;
            $response['status'] = 'min_order_error';
            return $response;
        }
        if ($existedProduct->min_order !== null && ((int)$addToCartData->productQty % (int)$existedProduct->min_order !== 0)) {
            $response['msg'] = __('theme.min-order-text') . ' ' . $existedProduct->min_order;
            $response['status'] = 'min_order_error';
            return $response;
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
                $response['msg'] = $this->buildLimitedStockMessage($existedProduct->stock);
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
                $response['in-cart'] = view('frontend.v1.components.product-card-summary-in-cart-content', ['product' => $existedProduct])->render();
            }
        }

        return $response;
    }

    /**
     * @param string $available
     * @return string
     */
    private function buildLimitedStockMessage(string $available): string
    {
        $unit = __('theme.in_cart_unit');
        $line1 = __('theme.limited_stock_only_qty', ['qty' => $available, 'unit' => $unit]);
        $line2 = __('theme.limited_stock_contact');
        return $line1 . "\n\n" . $line2;
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

    /**
     * @param string|int $sessionId
     * @return int
     */
    private function getProductCartCountPlural($sessionId)
    {
        return \Cart::session($sessionId)->getContent()->count();
    }

    /**
     * @param Product $product
     * @return string
     */
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

    /**
     * @param Product $product
     * @return float|int
     */
    public static function getProductSaleForLabel($product)
    {
        $user = Auth::guard('user')->user();
        $price = (float)$product->price;
        $priceKoef = (float)$product->price_koef;

        if ($user !== null && $user->with_sale) {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price - $price * ($user->sale / 100), 2, ',', '');
            } elseif($product->sale_price !== '' && $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, ',', '');
            }
            else{
                $price = number_format($price, 2, ',', '');
            }
        } else {
            if($user && $user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price * $priceKoef - $price * $priceKoef * ($user->sale / 100), 2, ',', '');
            } elseif($product->sale_price !== '' && $user && $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, ',', '');
            } else{
                $price = number_format($price * $priceKoef, 2, ',', '');
            }
        }

        return round((((float)$price - (float)$product->sale_price) / (float)$price) * 100);
    }

    /**
     * @param Product $product
     * @return string
     */
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

    /**
     * @param Product $product
     * @return string
     */
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

    /**
     * @param Product $product
     * @param User $user
     * @return string
     */
    public static function getPersonalizedProductPrice(Product $product, User $user): string
    {
        $price = (float)$product->price;
        $priceKoef = (float)$product->price_koef;

        if ($user->with_sale) {
            if($user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price - $price * ($user->sale / 100), 2, '.', '');
            } elseif($product->sale_price !== '' || $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, '.', '');
            }
            else{
                $price = number_format($price, 2, '.', '');
            }
        } else {
            if($user->sale !== null && $user->sale !== 0.0 && $product->sale_price === '') {
                $price = number_format($price * $priceKoef - $price * $priceKoef * ($user->sale / 100), 2, '.', '');
            } elseif($product->sale_price !== '' || $user->sale !== null && $user->sale !== 0.0) {
                $price = number_format((float)$product->sale_price, 2, '.', '');
            }
            else{
                $price = number_format($price * $priceKoef, 2, '.', '');
            }
        }

        return $price;
    }

}
