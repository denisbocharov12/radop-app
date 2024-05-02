<?php

declare(strict_types=1);

namespace App\Services\Theme\Product;

use App\Data\Theme\Product\AddToCartData;
use App\Exceptions\Product\ProductNotFoundException;
use App\Http\Requests\Theme\Product\AddToCartRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Collection;
use Gloudemans\Shoppingcart\Facades\Cart;

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

        $productId = $existedProduct->id;

        (int)$productQty = $addToCartData->productQty;

        $productStock = $existedProduct->stock;

        $price = $existedProduct->price;

        if ($existedProduct->sale_price !== '')
        {
            $price = $existedProduct->sale_price;
        }

        $cartArray = [];

        foreach (Cart::instance('cart')->content() as $item)
        {
            $cartArray[$item->rowId] = $item->id;
        }

        $productKey = array_search($productId, $cartArray);

        if (in_array($productId, $cartArray))
        {
            $exProduct = Cart::get($productKey);

            if ($productStock < (int)$exProduct->qty + (int)$productQty)
            {
                $response['msg'] = 'У нас нет столько товара на складе';
                $response['status'] = 'not_in_stock';
                $result = false;
            } else
            {
                $result = $this->addToInstance($productId,$existedProduct,$productQty,$price);
            }
        } else {
            $result = $this->addToInstance($productId,$existedProduct,$productQty,$price);
        }

        if ($result)
        {
            $response['status'] = true;
            $response['product_id'] = $productId;
            $response['product_title'] = $existedProduct->title;
            $response['total'] = Cart::instance('cart')->subtotal();
            $response['cart_count'] = Cart::instance('cart')->count();
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

    private function addToInstance(int $productId, Product $existedProduct, $productQty, $price)
    {

        return Cart::instance('cart')->add($productId,$existedProduct->title,$productQty,$price)->associate('Product');
    }
}
