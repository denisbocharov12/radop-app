<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Home;

use App\Enums\ProductConditions;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannerSetting;
use App\Repositories\Banner\BannerRepository;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;

final class ThemeHomeController extends Controller
{
    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly ProductRepository $productRepository,
        private readonly BannerRepository $bannerRepository,
    ) {
    }

    public function index()
    {
        $popularProducts = $this->productRepository->getAllPopularProducts();
        $newProducts = $this->productRepository->getAllNewProducts();
        $discountProducts = $this->productRepository->getAllDiscountProducts();
        $banners = $this->bannerRepository->getAllActiveForFront();
        $locale = app()->getLocale();
        $autoplaySpeed = BannerSetting::first()?->rotation_speed ?? 3000;

        $themeBrands = $this->brandRepository->getLimited();

        return view('frontend.v1.pages.home.index', compact([
            'themeBrands',
            'popularProducts',
            'newProducts',
            'discountProducts',
            'banners',
            'locale',
            'autoplaySpeed',
        ]));
    }
}
