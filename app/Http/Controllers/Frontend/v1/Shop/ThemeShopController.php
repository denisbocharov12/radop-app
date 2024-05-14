<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

final class ThemeShopController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository,
    )
    {
    }

    public function index(Request $request)
    {
        $query = $request->query('filter');

        $products = $this->productRepository->getAllPaginatedWithFiltersToFrontEnd();
        $brands = $this->brandRepository->getAll();

        return view('frontend.v1.pages.shop.index', compact([
            'products',
            'query',
            'brands'
        ]));
    }
}
