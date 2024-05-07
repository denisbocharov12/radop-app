<?php

namespace App\Http\Controllers\Frontend\v1\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Auth;

final class ThemeOrderController extends Controller
{
    public function __construct(
        private readonly OrderStatus $orderStatus,
        private readonly ProductRepository $productRepository
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $orderStatus = $this->orderStatus->getAll();
        $products = $this->productRepository->getAllPaginatedWithFilters();

        return view('frontend.v1.pages.order.index', compact([
            'user',
            'orderStatus',
            'products'
        ]));
    }
}
