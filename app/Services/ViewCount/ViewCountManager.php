<?php

declare(strict_types=1);

namespace App\Services\ViewCount;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

final class ViewCountManager
{
    /**
     * @param Product $product
     * @param Request $request
     */
    public function incrementProductViewCount(Product $product, Request $request): void
    {
        return;
    }

    /**
     * @param Brand $brand
     * @param Request $request
     */
    public function incrementBrandViewCount(Brand $brand, Request $request): void
    {
        return;
    }

    /**
     * @param Category $category
     * @param Request $request
     */
    public function incrementCategoryViewCount(Category $category, Request $request): void
    {
        return;
    }

    /**
     * @return string
     */
    public function getClientIp(): string
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){

            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }

        return request()->ip();
    }
}
