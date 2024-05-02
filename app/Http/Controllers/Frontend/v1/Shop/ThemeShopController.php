<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Shop;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

final class ThemeShopController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->getAllPaginatedWithFilters();

        return view('frontend.v1.pages.shop.index', compact([
            'products',
        ]));
    }
}
