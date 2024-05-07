<?php

namespace App\Http\Controllers\Frontend\v1\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

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

    public function ViewInvoice(Request $request){
        $id = $request->input('order');
        $order = Order::where('id', $id)->get();
        $order_items = OrderItem::where('order_id', $id)->get();
        $manager = User::where('id',$order[0]->manager_id)->first();
        if(empty($manager)){
            $manager = new User();
            $manager->first_name = 'Менеджер';
            $manager->last_name = 'по продажам RadopMD';
        }
        $pdf = PDF::loadView('invoice.order-printing', compact(['order','order_items','manager']));
        return $pdf->stream();
    }

    public function GenerateInvoice(Request $request){
        $id = $request->input('order');
        $order = Order::where('id', $id)->get();
        $order_items = OrderItem::where('order_id', $id)->get();
        $manager = User::where('id',$order[0]->manager_id)->first();
        if(empty($manager)){
            $manager = new User();
            $manager->first_name = 'Менеджер';
            $manager->last_name = 'по продажам RadopMD';
        }
        $pdf = PDF::loadView('invoice.order-printing', compact(['order','order_items','manager']));
        return $pdf->download();

    }
}
