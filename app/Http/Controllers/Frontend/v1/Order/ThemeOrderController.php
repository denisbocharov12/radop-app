<?php

namespace App\Http\Controllers\Frontend\v1\Order;

use App\Enums\OrderStatus;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderNotFoundValidationException;
use App\Exceptions\Order\UserIsNotCustomerException;
use App\Exceptions\Order\UserIsNotCustomerValidationException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Product\ProductRepository;
use App\Services\Theme\Order\ThemeOrderManager;
use Illuminate\Support\Facades\Auth;

final class ThemeOrderController extends Controller
{
    public function __construct(
        private readonly OrderStatus $orderStatus,
        private readonly ProductRepository $productRepository,
        private readonly ThemeOrderManager $themeOrderManager
    )
    {
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $orderStatus = $this->orderStatus->getAll();
        $products = $this->productRepository->getAll();

        return view('frontend.v1.pages.order.index', compact([
            'user',
            'orderStatus',
            'products'
        ]));
    }

    public function viewInvoice(Order $order)
    {
        $user = Auth::guard('user')->user();

        try {
            return $this->themeOrderManager->viewInvoice($order, $user);
        } catch (UserIsNotCustomerException $e){
            throw new UserIsNotCustomerValidationException();
        } catch (OrderNotFoundException $e){
            throw new OrderNotFoundValidationException();
        }
    }

    public function downloadInvoice(Order $order)
    {
        $user = Auth::guard('user')->user();

        try {
            return $this->themeOrderManager->downloadInvoice($order, $user);
        } catch (UserIsNotCustomerException $e){
            throw new UserIsNotCustomerValidationException();
        } catch (OrderNotFoundException $e){
            throw new OrderNotFoundValidationException();
        }
    }
}
