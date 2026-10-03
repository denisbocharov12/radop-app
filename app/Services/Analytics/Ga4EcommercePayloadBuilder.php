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
            $price = $this->money((float) $row->price);
            $value += $price * $quantity;
            $items[] = $this->buildItem($model, [
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }
        if ($items === []) {
            return null;
        }

        return [
            'currency' => $currencyCode,
            'value' => $this->money($value),
            'items' => $items,
        ];
    }

    /**
     * Состав товара для любого события электронной торговли.
     *
     * Справочник Google (reference/events) ждёт у каждого item кроме кода и
     * названия ещё бренд, категорию и affiliation — без них отчёты по брендам
     * и категориям в GA4 пустые. Собираем это в одном месте, чтобы состав не
     * расходился между страницей товара, списками и корзиной.
     *
     * @param  array<string, mixed>  $extra
     * @return array<string, mixed>
     */
    public function buildItem(Product $product, array $extra = []): array
    {
        $row = [
            'item_id' => (string) ($product->onec_id ?? $product->id),
            'item_name' => $this->productTitle($product),
            'affiliation' => (string) config('analytics.affiliation', 'Radop'),
            'price' => $this->money((float) ThemeProductManager::getProductTotalSum($product)),
            'quantity' => 1,
        ];

        $brand = $this->brandName($product);

        if ($brand !== null) {
            $row['item_brand'] = $brand;
        }

        $category = $this->categoryName($product);

        if ($category !== null) {
            $row['item_category'] = $category;
        }

        return array_merge($row, $extra);
    }

    public function money(float $value): float
    {
        return round($value, 2);
    }

    private function brandName(Product $product): ?string
    {
        // Связь грузится списками заранее; на одиночном товаре допускаем
        // ленивую подгрузку — это один запрос на страницу.
        $brand = $product->brand;

        if ($brand === null) {
            return null;
        }

        $title = $brand->getTranslation('title', app()->getLocale(), false);

        return is_string($title) && $title !== '' ? strip_tags($title) : null;
    }

    private function categoryName(Product $product): ?string
    {
        if (! $product->relationLoaded('categories')) {
            return null;
        }

        $category = $product->categories->first();

        if ($category === null) {
            return null;
        }

        $name = $category->getTranslation('name', app()->getLocale(), false);

        return is_string($name) && $name !== '' ? strip_tags($name) : null;
    }

    /**
     * @return array<string, mixed>
     */
    private function buildListItemRow(Product $product, int $position): array
    {
        return $this->buildItem($product, ['index' => $position + 1]);
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
