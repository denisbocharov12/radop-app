<?php

namespace App\Http\Controllers\Frontend\v1\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

final class ThemeOrderController extends Controller
{
    public function __construct(
        private readonly OrderStatus $orderStatus
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $orderStatus = $this->orderStatus->getAll();

        return view('frontend.v1.pages.order.index', compact([
            'user',
            'orderStatus'
        ]));
    }
}
