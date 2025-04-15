<?php

namespace App\Http\Controllers\Frontend\v1\Order;

use App\Enums\OrderStatus;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderNotFoundValidationException;
use App\Exceptions\Order\UserIsNotCustomerException;
use App\Exceptions\Order\UserIsNotCustomerValidationException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Order\ThemeOrderManager;
use Illuminate\Support\Facades\Auth;

final class ThemeOrderController extends Controller
{
    public function __construct(
        private readonly OrderStatus $orderStatus,
        private readonly ProductRepository $productRepository,
        private readonly ThemeOrderManager $themeOrderManager,
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $orderStatus = $this->orderStatus->getAll();
        $products = $this->productRepository->getAll();
        $orders = $this->orderRepository->getByUserIdPaginated($user->id);

        return view('frontend.v1.pages.order.index', compact([
            'user',
            'orderStatus',
            'products',
            'orders'
        ]));
    }

    public function viewInvoice(Order $order)
    {
        $user = Auth::guard('user')->user();
        $orderStatus = $this->orderStatus->getAll();
        $existedOrder = $this->orderRepository->getById($order->id);

        if ($existedOrder === null){
            return redirect()->back()->withErrors(['order_not_found' => __('theme.order_not_found')]);
        }

        if (!$user->can('view', $order)) {
            return redirect()->back()->withErrors(['user_not_permitted_to_view_order' => __('theme.user_not_permitted_to_view_order')]);
        }

        return view('frontend.v1.pages.order.show', compact([
            'user',
            'orderStatus',
            'order'
        ]));
    }

    public function downloadInvoice(Order $order)
    {
        $user = Auth::guard('user')->user();

        try {
            return $this->themeOrderManager->downloadInvoice($order, $user);
        } catch (UserIsNotCustomerException $e){
            return redirect()->back()->withErrors(['user_not_permitted_to_view_order' => __('theme.user_not_permitted_to_view_order')]);
        } catch (OrderNotFoundException $e){
            throw new OrderNotFoundValidationException();
        }
    }
}
