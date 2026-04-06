<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

final class CanonicalUrlResolver
{
    /**
     * Map of static page_type → named route.
     */
    private const STATIC_ROUTES = [
        'home'             => 'theme.home',
        'about'            => 'theme.about-us',
        'contact'          => 'theme.contacts.index',
        'delivery'         => 'theme.delivery.index',
        'shop'             => 'theme.shop.index',
        'shop_catalog'     => 'theme.shop.catalog',
        'new_products'     => 'theme.shop.new',
        'sale_products'    => 'theme.shop.sale',
        'popular_products' => 'theme.shop.popular',
        'brands_catalog'   => 'theme.brand.catalog',
        'my_orders'        => 'theme.user.orders.index',
        'privacy_policy'   => 'theme.privacy-policy.index',
        'terms_conditions' => 'theme.terms-and-conditions.index',
        'return_rules'     => 'theme.return-rules.index',
        'order_guide'      => 'theme.order-guide.index',
        'cookie'           => 'theme.cookie.index',
        'search'           => 'theme.search.index',
        'account'          => 'theme.user.account.index',
        'wishlist'         => 'theme.wishlist.index',
        'cart'             => 'theme.cart.index',
        'checkout'         => 'theme.checkout.index',
        'login'            => 'theme.user.login',
        'registration'     => 'theme.user.register',
    ];

    /**
     * Resolve the canonical URL for a SeoMeta record.
     * Returns null if the URL cannot be determined.
     */
    public function resolve(string $pageType, ?string $pageId): ?string
    {
        // Static pages – no dynamic param needed
        if (isset(self::STATIC_ROUTES[$pageType])) {
            $routeName = self::STATIC_ROUTES[$pageType];
            if (\Route::has($routeName)) {
                return route($routeName);
            }
            return null;
        }

        // Dynamic pages – require page_id
        if (empty($pageId)) {
            return null;
        }

        return match ($pageType) {
            'product'  => $this->resolveProduct($pageId),
            'category' => $this->resolveCategory($pageId),
            'brand'    => $this->resolveBrand($pageId),
            default    => null,
        };
    }

    private function resolveProduct(string $pageId): ?string
    {
        if (!\Route::has('theme.product.index')) {
            return null;
        }

        $product = Product::where('onec_id', $pageId)
            ->orWhere('id', $pageId)
            ->value('slug');

        return $product ? route('theme.product.index', $product) : null;
    }

    private function resolveCategory(string $pageId): ?string
    {
        if (!\Route::has('theme.category.index')) {
            return null;
        }

        $exists = Category::where('onec_id', $pageId)->exists();
        return $exists ? route('theme.category.index', $pageId) : null;
    }

    private function resolveBrand(string $pageId): ?string
    {
        if (!\Route::has('theme.brand.index')) {
            return null;
        }

        $exists = Brand::where('onec_id', $pageId)->exists();
        return $exists ? route('theme.brand.index', $pageId) : null;
    }
}
