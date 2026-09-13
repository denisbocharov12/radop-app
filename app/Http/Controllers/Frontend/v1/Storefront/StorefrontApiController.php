<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\v1\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Storefront\StorefrontProductPresenter;
use Illuminate\Http\JsonResponse;

/**
 * Read-only JSON for the storefront's Vue islands.
 *
 * The legacy endpoints answer with server-rendered HTML fragments
 * (`quick-view-v2`, `mini-cart`) styled for the old stylesheet; these return
 * data instead so the islands render it with the design system.
 */
final class StorefrontApiController extends Controller
{
    public function __construct(
        private readonly StorefrontProductPresenter $presenter,
    ) {
    }

    /**
     * Header mini-cart: lines, total and the minimum-order state.
     */
    public function cartSummary(): JsonResponse
    {
        $user = auth()->guard('user')->user();
        $session = $user ? $user->id : config('shopping_cart.default_session_id');
        $cart = \Cart::session($session);

        $lines = $cart->getContent()
            ->sortBy('attributes.added_at')
            ->filter(static fn ($item) => $item->associatedModel instanceof Product)
            ->map(function ($item) {
                $card = $this->presenter->present($item->associatedModel);

                return [
                    'id' => (int) $item->id,
                    'title' => $card['title'],
                    'code' => $card['code'],
                    'url' => $card['url'],
                    'image' => $card['image'],
                    'qty' => (int) $item->quantity,
                    'lineTotal' => number_format((float) $item->price * (int) $item->quantity, 2, ',', ' '),
                ];
            })
            ->values();

        $total = (float) $cart->getTotal();
        $minSum = $user
            ? ($user->isSupplementWindowOpen() ? 0.0 : (float) $user->minOrderSum())
            : (float) config('app.min_delivery_sum');

        return response()->json([
            'lines' => $lines,
            'count' => $lines->count(),
            'total' => number_format($total, 2, ',', ''),
            'minOrderSum' => $minSum,
            'remaining' => number_format(max($minSum - $total, 0), 2, ',', ''),
            'belowMinimum' => $minSum > 0 && $total < $minSum,
        ]);
    }

    /**
     * Quick view: card data, gallery, specifications and basket state.
     */
    public function productPreview(int $product): JsonResponse
    {
        $model = Product::query()
            ->with(['values.attribute', 'packages', 'brand', 'media'])
            ->where('status', true)
            ->where('site_status', true)
            ->find($product);

        abort_if($model === null, 404);

        $user = auth()->guard('user')->user();
        $session = $user ? $user->id : config('shopping_cart.default_session_id');
        $line = \Cart::session($session)->get($model->id);

        return response()->json($this->presenter->presentDetailed($model) + [
            'inCart' => $line ? (int) $line->quantity : 0,
            'inWishlist' => app('wishlist')->get($model->id) !== null,
        ]);
    }
}
