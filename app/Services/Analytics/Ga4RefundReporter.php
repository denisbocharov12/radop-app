<?php

declare(strict_types=1);

namespace App\Services\Analytics;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

/**
 * Возврат заказа в GA4 (ТЗ 17).
 *
 * Полный возврат — только номер заказа и сумма; частичный — ещё и состав
 * возвращаемых позиций. transaction_id совпадает с тем, что ушёл в purchase,
 * иначе GA4 не свяжет возврат с покупкой.
 */
final class Ga4RefundReporter
{
    public function __construct(
        private readonly Ga4MeasurementProtocol $protocol,
        private readonly Ga4EcommercePayloadBuilder $items,
    ) {
    }

    /**
     * @param  array<string, int>  $returnedQuantities  код товара 1С => количество
     * @return array{sent: bool, payload: array<string, mixed>, reason?: string, response?: mixed}
     */
    public function report(Order $order, array $returnedQuantities = [], ?float $amount = null, bool $debug = false): array
    {
        $order->loadMissing(['products.product']);

        $payload = [
            'transaction_id' => (string) ($order->order_number ?: $order->id),
            'currency' => (string) config('analytics.currency', 'MDL'),
        ];

        $items = [];
        $value = 0.0;

        foreach ($order->products as $line) {
            $product = $line->product;

            if (! $product instanceof Product) {
                continue;
            }

            $code = (string) ($product->onec_id ?? $product->id);
            $quantity = (int) $line->quantity;

            if ($returnedQuantities !== []) {
                if (! array_key_exists($code, $returnedQuantities)) {
                    continue;
                }

                $quantity = min($quantity, max(1, (int) $returnedQuantities[$code]));
            }

            $price = round((float) $line->price, 2);
            $value += $price * $quantity;

            $items[] = $this->items->buildItem($product, [
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }

        // Для полного возврата состав можно не передавать, но с ним отчёты
        // по товарам тоже сходятся, поэтому отправляем, когда он известен.
        if ($items !== []) {
            $payload['items'] = $items;
        }

        $payload['value'] = $amount !== null
            ? round($amount, 2)
            : ($returnedQuantities === [] ? round((float) $order->total, 2) : round($value, 2));

        $result = $this->protocol->send(
            [['name' => 'refund', 'params' => $payload]],
            'order-' . $payload['transaction_id'],
            $debug,
        );

        Log::info('GA4 refund', ['order' => $payload['transaction_id'], 'sent' => $result['sent'], 'value' => $payload['value']]);

        return $result + ['payload' => $payload];
    }
}
