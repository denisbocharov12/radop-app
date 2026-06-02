<?php

declare(strict_types=1);

namespace App\Services\Seo;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;

/**
 * SEO generator backed by Anthropic Claude (Messages API).
 *
 * Uses a plain Guzzle HTTP call — no extra SDK dependency required.
 * Requires CLAUDE_API_KEY (an Anthropic *API* key from console.anthropic.com,
 * which is billed separately from a Claude.ai chat subscription).
 *
 * @see https://docs.anthropic.com/en/api/messages
 */
final class ClaudeSeoGeneratorService extends AbstractSeoGeneratorService
{
    public function provider(): string
    {
        return 'claude';
    }

    /**
     * Call the Anthropic Messages API and return the raw text answer.
     */
    protected function complete(string $prompt): string
    {
        $apiKey = (string) config('claude.api_key');

        if ($apiKey === '') {
            throw new \RuntimeException('CLAUDE_API_KEY не задан в .env — генерация через Claude недоступна.');
        }

        $model    = config('claude.model', 'claude-3-5-sonnet-latest');
        $baseUrl  = rtrim((string) config('claude.base_url', 'https://api.anthropic.com'), '/');
        $version  = (string) config('claude.version', '2023-06-01');
        $maxTok   = (int) config('claude.max_tokens', 1024);

        $guzzle = new GuzzleClient([
            'timeout' => (int) config('claude.request_timeout', 60),
            'verify'  => (bool) config('claude.ssl_verify', true),
        ]);

        $response = $guzzle->post($baseUrl . '/v1/messages', [
            'headers' => [
                'x-api-key'         => $apiKey,
                'anthropic-version' => $version,
                'content-type'      => 'application/json',
            ],
            'json' => [
                'model'      => $model,
                'max_tokens' => $maxTok,
                // Force the model to answer with JSON only.
                'system'     => 'You are an SEO API. Respond ONLY with a single valid JSON object. No markdown, no prose, no code fences.',
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ],
        ]);

        $payload = json_decode((string) $response->getBody(), true);

        if (!is_array($payload) || !isset($payload['content'][0]['text'])) {
            Log::warning('Claude SEO: Unexpected response shape', ['payload' => $payload]);
            throw new \RuntimeException('Claude вернул неожиданный ответ.');
        }

        // Concatenate all text blocks (Claude may split the answer).
        $text = '';
        foreach ($payload['content'] as $block) {
            if (($block['type'] ?? null) === 'text' && isset($block['text'])) {
                $text .= $block['text'];
            }
        }

        return trim($text);
    }
}
