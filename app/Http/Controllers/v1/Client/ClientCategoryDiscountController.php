<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\UserCategoryDiscount;
use App\Models\UserProductDiscount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ClientCategoryDiscountController extends Controller
{
    /**
     * Hierarchical list of categories for the dropdown: parents first, each
     * child indented under its parent so the tree is easy to read.
     */
    public function categories(): JsonResponse
    {
        $all = Category::query()
            ->orderBy('name')
            ->get(['onec_id', 'name', 'parent_id']);

        // Group children by their parent's onec_id (roots under a sentinel key).
        $byParent = [];
        foreach ($all as $c) {
            $key = $c->parent_id === null ? '__root__' : (string) $c->parent_id;
            $byParent[$key][] = $c;
        }

        $result   = [];
        $included = [];

        $walk = function (string $parentKey, int $depth) use (&$walk, &$result, &$included, $byParent): void {
            foreach ($byParent[$parentKey] ?? [] as $c) {
                $onec = (string) $c->onec_id;
                $included[$onec] = true;

                $result[] = [
                    'onec_id' => $onec,
                    'name'    => ($depth > 0 ? str_repeat('— ', $depth) : '') . (string) $c->name,
                    'depth'   => $depth,
                ];

                $walk($onec, $depth + 1);
            }
        };
        $walk('__root__', 0);

        // Safety: append any categories whose parent is missing (orphans).
        foreach ($all as $c) {
            $onec = (string) $c->onec_id;
            if (!isset($included[$onec])) {
                $result[] = ['onec_id' => $onec, 'name' => (string) $c->name, 'depth' => 0];
            }
        }

        return response()->json(['status' => true, 'data' => $result]);
    }

    /**
     * The user's existing category- and product-level discounts.
     */
    public function data(User $user): JsonResponse
    {
        $categoryDiscounts = $user->categoryDiscounts()->get()->map(function (UserCategoryDiscount $d) {
            $category = Category::where('onec_id', $d->category_onec_id)->first();

            return [
                'category_onec_id' => (string) $d->category_onec_id,
                'category_name'    => $category?->name ?? $d->category_onec_id,
                'discount_percent' => (float) $d->discount_percent,
            ];
        })->values();

        $productDiscounts = $user->productDiscounts()->get()->map(function (UserProductDiscount $d) {
            $product = Product::where('onec_id', $d->product_onec_id)->first();

            return [
                'product_onec_id' => (string) $d->product_onec_id,
                'product_title'   => $product?->title ?? $d->product_onec_id,
                'discount_type'   => (string) $d->discount_type,
                'discount_value'  => (float) $d->discount_value,
            ];
        })->values();

        return response()->json([
            'status'             => true,
            'category_discounts' => $categoryDiscounts,
            'product_discounts'  => $productDiscounts,
        ]);
    }

    /**
     * Products of a category + the user's current per-product discount for each.
     */
    public function products(User $user, Request $request): JsonResponse
    {
        $request->validate(['category_id' => ['required', 'string']]);
        $categoryOnecId = (string) $request->query('category_id');

        $category = Category::where('onec_id', $categoryOnecId)->first();
        if ($category === null) {
            return response()->json(['status' => false, 'message' => 'Категория не найдена'], 404);
        }

        $existing = $user->productDiscounts()
            ->get()
            ->keyBy('product_onec_id');

        $products = $category->products()
            ->where('products.status', true)
            ->orderBy('products.title')
            ->get(['products.onec_id', 'products.title'])
            ->map(function (Product $p) use ($existing) {
                $d = $existing->get((string) $p->onec_id);

                return [
                    'onec_id'        => (string) $p->onec_id,
                    'title'          => (string) $p->title,
                    'discount_type'  => $d?->discount_type,
                    'discount_value' => $d !== null ? (float) $d->discount_value : null,
                ];
            })
            ->values();

        return response()->json(['status' => true, 'data' => $products]);
    }

    /**
     * Save / update / remove a whole-category percent discount.
     */
    public function saveCategory(User $user, Request $request): JsonResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'string'],
            'percent'     => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $categoryOnecId = (string) $data['category_id'];
        $percent = $data['percent'] ?? null;

        if (Category::where('onec_id', $categoryOnecId)->doesntExist()) {
            return response()->json(['status' => false, 'message' => 'Категория не найдена'], 404);
        }

        // Empty / zero → remove the discount.
        if ($percent === null || (float) $percent <= 0) {
            $user->categoryDiscounts()->where('category_onec_id', $categoryOnecId)->delete();

            return response()->json(['status' => true, 'message' => 'Скидка по категории удалена', 'removed' => true]);
        }

        UserCategoryDiscount::updateOrCreate(
            ['user_id' => $user->id, 'category_onec_id' => $categoryOnecId],
            ['discount_percent' => round((float) $percent, 2)],
        );

        return response()->json(['status' => true, 'message' => 'Скидка по категории сохранена']);
    }

    /**
     * Save / update / remove a per-product discount (percent or fixed price).
     */
    public function saveProduct(User $user, Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id'  => ['required', 'string'],
            'category_id' => ['nullable', 'string'],
            'type'        => ['nullable', 'in:percent,fixed'],
            'value'       => ['nullable', 'numeric', 'min:0'],
        ]);

        $productOnecId = (string) $data['product_id'];
        $type  = $data['type'] ?? null;
        $value = $data['value'] ?? null;

        if (Product::where('onec_id', $productOnecId)->doesntExist()) {
            return response()->json(['status' => false, 'message' => 'Товар не найден'], 404);
        }

        // Empty type/value → remove.
        if ($type === null || $value === null || (float) $value <= 0) {
            $user->productDiscounts()->where('product_onec_id', $productOnecId)->delete();

            return response()->json(['status' => true, 'message' => 'Скидка на товар удалена', 'removed' => true]);
        }

        if ($type === UserProductDiscount::TYPE_PERCENT && (float) $value > 100) {
            return response()->json(['status' => false, 'message' => 'Процент не может превышать 100'], 422);
        }

        UserProductDiscount::updateOrCreate(
            ['user_id' => $user->id, 'product_onec_id' => $productOnecId],
            [
                'category_onec_id' => $data['category_id'] ?? null,
                'discount_type'    => $type,
                'discount_value'   => round((float) $value, 2),
            ],
        );

        return response()->json(['status' => true, 'message' => 'Скидка на товар сохранена']);
    }
}
