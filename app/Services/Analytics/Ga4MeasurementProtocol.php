<?php

declare(strict_types=1);

namespace App\Services\Analytics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Отправка событий в GA4 с сервера (Measurement Protocol).
 *
 * Нужна там, где события некому отправить из браузера: возврат заказа
 * подтверждают в учётной системе, покупателя на сайте в этот момент нет
 * (ТЗ 17).
 *
 * Требуются GA4_MEASUREMENT_ID и GA4_API_SECRET (ключ создаётся в GA4:
 * «Администратор → Потоки данных → Measurement Protocol API secrets»).
 */
final class Ga4MeasurementProtocol
{
    private const ENDPOINT = 'https://www.google-analytics.com/mp/collect';
    private const DEBUG_ENDPOINT = 'https://www.google-analytics.com/debug/mp/collect';

    public function isConfigured(): bool
    {
        return $this->measurementId() !== '' && $this->apiSecret() !== '';
    }

    /**
     * @param  array<int, array{name: string, params: array<string, mixed>}>  $events
     * @return array{sent: bool, reason?: string, response?: mixed}
     */
    public function send(array $events, ?string $clientId = null, bool $debug = false): array
    {
        if (! $this->isConfigured()) {
            return ['sent' => false, 'reason' => 'Не заданы GA4_MEASUREMENT_ID или GA4_API_SECRET'];
        }

        if ($events === []) {
            return ['sent' => false, 'reason' => 'Нечего отправлять'];
        }

        $payload = [
            // Без клиента GA4 событие не примет: для серверных событий без
            // посетителя подойдёт устойчивый идентификатор заказа.
            'client_id' => $clientId ?: (string) Str::uuid(),
            'non_personalized_ads' => false,
            'events' => $events,
        ];

        try {
            $response = Http::timeout(10)
                ->asJson()
                ->post(($debug ? self::DEBUG_ENDPOINT : self::ENDPOINT) . '?' . http_build_query([
                    'measurement_id' => $this->measurementId(),
                    'api_secret' => $this->apiSecret(),
                ]), $payload);
        } catch (\Throwable $e) {
            Log::error('GA4 Measurement Protocol: ' . $e->getMessage());

            return ['sent' => false, 'reason' => $e->getMessage()];
        }

        // Обычный адрес отвечает пустым телом и кодом 204 — это успех.
        return [
            'sent' => $response->successful(),
            'response' => $debug ? $response->json() : $response->status(),
        ];
    }

    private function measurementId(): string
    {
        return (string) config('analytics.ga4_measurement_id', '');
    }

    private function apiSecret(): string
    {
        return (string) config('analytics.ga4_api_secret', '');
    }
}
