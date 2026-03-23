<?php

declare(strict_types=1);

namespace App\Services\Analytics;

use App\Models\Product;
use App\Services\Theme\Product\ThemeProductManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class Ga4EcommercePayloadBuilder
{
    /**
     * @param iterable<int, mixed> $products
     * @return array{item_list_id: string, item_list_name: string, items: list<array<string, mixed>>}|null
     */
    public function buildViewItemList(iterable $products, string $listId, string $listName, int $maxItems = 200): ?array
    {
        $items = [];
        $index = 0;
        foreach ($products as $product) {
            if (!$product instanceof Product) {
                continue;
            }
            if ($index >= $maxItems) {
                break;
            }
            $items[] = $this->buildListItemRow($product, $index);
            $index++;
        }
        if ($items === []) {
            return null;
        }

        return [
            'item_list_id' => $listId,
            'item_list_name' => $listName,
            'items' => $items,
        ];
    }

    /**
     * @return array{item_list_id: string, item_list_name: string, items: list<array<string, mixed>>}|null
     */
    public function buildViewItemListFromPaginator(LengthAwarePaginator $paginator, string $listId, string $listName, int $maxItems = 200): ?array
    {
        return $this->buildViewItemList($paginator->items(), $listId, $listName, $maxItems);
    }

    /**
     * @param Collection<int, Product> $collection
     * @return array{item_list_id: string, item_list_name: string, items: list<array<string, mixed>>}|null
     */
    public function buildViewItemListFromCollection(Collection $collection, string $listId, string $listName, int $maxItems = 200): ?array
    {
        return $this->buildViewItemList($collection, $listId, $listName, $maxItems);
    }

    /**
     * @return array{currency: string, value: float, items: list<array<string, mixed>>}|null
     */
    public function buildViewCart(int|string $sessionId, ?string $currency = null): ?array
    {
        $currencyCode = $currency ?? (string) config('analytics.currency', 'MDL');
        $cart = \Cart::session($sessionId)->getContent();
        if ($cart->isEmpty()) {
            return null;
        }
        $items = [];
        $value = 0.0;
        foreach ($cart as $row) {
            $model = $row->associatedModel;
            if (!$model instanceof Product) {
                continue;
            }
            $quantity = (int) $row->quantity;
            $price = (float) $row->price;
            $value += $price * $quantity;
            $items[] = [
                'item_id' => (string) ($model->onec_id ?? $model->id),
                'item_name' => $this->productTitle($model),
                'price' => $price,
                'quantity' => $quantity,
            ];
        }
        if ($items === []) {
            return null;
        }

        return [
            'currency' => $currencyCode,
            'value' => $value,
            'items' => $items,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildListItemRow(Product $product, int $position): array
    {
        $price = (float) ThemeProductManager::getProductTotalSum($product);
        $row = [
            'item_id' => (string) ($product->onec_id ?? $product->id),
            'item_name' => $this->productTitle($product),
            'price' => $price,
            'index' => $position + 1,
            'quantity' => 1,
        ];
        if ($product->relationLoaded('brand') && $product->brand !== null) {
            $brandTitle = $product->brand->getTranslation('title', app()->getLocale(), false);
            if (is_string($brandTitle) && $brandTitle !== '') {
                $row['item_brand'] = strip_tags($brandTitle);
            }
        }

        return $row;
    }

    private function productTitle(Product $product): string
    {
        $t = $product->getTranslation('title', app()->getLocale(), false);
        if (is_string($t) && $t !== '') {
            return strip_tags($t);
        }
        $raw = $product->title;
        if (is_string($raw)) {
            return strip_tags($raw);
        }

        return 'item';
    }
}
