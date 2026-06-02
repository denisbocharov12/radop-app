<?php

declare(strict_types=1);

namespace App\Services\Seo;

use GuzzleHttp\Client as GuzzleClient;

/**
 * SEO generator backed by Google Gemini.
 *
 * All prompt construction and response parsing live in
 * {@see AbstractSeoGeneratorService}; this class only performs the API call.
 */
final class GeminiSeoGeneratorService extends AbstractSeoGeneratorService
{
    public function provider(): string
    {
        return 'gemini';
    }

    /**
     * Call Gemini API and return the raw text answer.
     */
    protected function complete(string $prompt): string
    {
        $model  = config('gemini.model', 'gemini-1.5-flash');
        $guzzle = new GuzzleClient([
            'timeout' => (int) config('gemini.request_timeout', 30),
            'verify'  => (bool) config('gemini.ssl_verify', true),
        ]);

        $baseUrl = config('gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta/');

        $client = \Gemini::factory()
            ->withApiKey(apiKey: config('gemini.api_key'))
            ->withBaseUrl(baseUrl: $baseUrl)
            ->withHttpClient(client: $guzzle)
            ->make();

        $response = $client->generativeModel(model: $model)->generateContent($prompt);

        return trim($response->text());
    }
}
