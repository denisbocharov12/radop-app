<?php

namespace App\Http\Controllers\Frontend\v1\Order;

use App\Enums\OrderStatus;
use App\Enums\PageTypes;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderNotFoundValidationException;
use App\Exceptions\Order\UserIsNotCustomerException;
use App\Exceptions\Order\UserIsNotCustomerValidationException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\SeoMetaRepository;
use App\Services\Theme\Order\ThemeOrderManager;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;

final class ThemeOrderController extends Controller
{
    use SEOTools;

    public function __construct(
        private readonly OrderStatus $orderStatus,
        private readonly ProductRepository $productRepository,
        private readonly ThemeOrderManager $themeOrderManager,
        private readonly OrderRepository $orderRepository,
        private readonly SeoMetaRepository $seoMetaRepository,
        private readonly PageTypes $pageTypes,
    )
    {
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::guard('user')->user();
        $orderStatus = $this->orderStatus->getAll();
        $products = $this->productRepository->getAll();
        $orders = $this->orderRepository->getByUserIdPaginated($user->id);

        $seo = $this->seoMetaRepository->getStatic($this->pageTypes->getMyOrdersType(), app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(route('theme.order.index'));
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.order.index', compact([
            'user',
            'orderStatus',
            'products',
            'orders'
        ]));
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
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

        $seo = $this->seoMetaRepository->get($this->pageTypes->getMyOrdersType(), (string)$order->id, app()->getLocale());

        if ($seo !== null) {
            $this->seo()->setTitle($seo->title ?? trans('seo.title', [], app()->getLocale()));
            $this->seo()->setDescription($seo->description ?? trans('seo.description', [], app()->getLocale()));
            $this->seo()->addImages($seo?->getFirstMediaUrl() ?? config('seotools.meta.defaults.default_image'));

            (array)$seoKeywords = $seo?->keywords !== null && $seo?->keywords !== '' ? explode(',', $seo?->keywords) : trans('seo.keywords', [], app()->getLocale());

            SEOMeta::setKeywords($seoKeywords);

            $this->seo()->opengraph()->setUrl(request()->url());
            $this->seo()->opengraph()->addProperty('type', 'page');
            $this->seo()->jsonLd()->setType('WebPage');
        }

        return view('frontend.v1.pages.order.show', compact([
            'user',
            'orderStatus',
            'order'
        ]));
    }

    /**
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
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
