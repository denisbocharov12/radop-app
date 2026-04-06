<?php

declare(strict_types=1);

namespace App\Services\Seo;

use Gemini\Laravel\Facades\Gemini;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;

final class GeminiSeoGeneratorService
{
    private const SITE_NAME = 'Radop';
    private const SITE_DOMAIN = 'radop.md';
    private const SITE_COUNTRY = 'Moldova';

    /**
     * Generate SEO for a product.
     */
    public function generateForProduct(array $context, string $locale): array
    {
        $langName = $this->getLangName($locale);
        $title = $context['title'] ?? '';
        $category = $context['category'] ?? '';
        $brand = $context['brand'] ?? '';
        $summary = $context['summary'] ?? '';

        $prompt = <<<PROMPT
You are an SEO expert for an online electronics store "{$this->getSiteName()}" ({$this->getSiteDomain()}) based in {$this->getSiteCountry()}.

Generate SEO metadata for this product page in {$langName}.

Product title: {$title}
Category: {$category}
Brand: {$brand}
Description: {$summary}

Rules:
- Title: max 60 characters, include product name and brand, natural language in {$langName}
- Description: max 160 characters, compelling, include key features and call-to-action in {$langName}
- Keywords: 5-8 comma-separated keywords relevant to this product in {$langName}
- All text must be in {$langName} language

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->callGemini($prompt);
    }

    /**
     * Generate SEO for a category.
     */
    public function generateForCategory(array $context, string $locale): array
    {
        $langName = $this->getLangName($locale);
        $name = $context['name'] ?? '';
        $parent = $context['parent'] ?? '';
        $summary = $context['summary'] ?? '';
        $parentStr = $parent ? "Parent category: {$parent}" : '';

        $prompt = <<<PROMPT
You are an SEO expert for an online electronics store "{$this->getSiteName()}" ({$this->getSiteDomain()}) based in {$this->getSiteCountry()}.

Generate SEO metadata for this product category page in {$langName}.

Category name: {$name}
{$parentStr}
Category description: {$summary}

Rules:
- Title: max 60 characters, include category name, natural language in {$langName}
- Description: max 160 characters, describe what products are in this category, include store name in {$langName}
- Keywords: 5-8 comma-separated keywords relevant to this category in {$langName}
- All text must be in {$langName} language

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->callGemini($prompt);
    }

    /**
     * Generate SEO for a brand.
     */
    public function generateForBrand(array $context, string $locale): array
    {
        $langName = $this->getLangName($locale);
        $name = $context['name'] ?? '';
        $description = $context['description'] ?? '';

        $prompt = <<<PROMPT
You are an SEO expert for an online electronics store "{$this->getSiteName()}" ({$this->getSiteDomain()}) based in {$this->getSiteCountry()}.

Generate SEO metadata for this brand page in {$langName}.

Brand name: {$name}
Brand description: {$description}

Rules:
- Title: max 60 characters, include brand name and product types, natural language in {$langName}
- Description: max 160 characters, describe the brand and available products in {$langName}
- Keywords: 5-8 comma-separated keywords for this brand in {$langName}
- All text must be in {$langName} language

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->callGemini($prompt);
    }

    /**
     * Generate SEO for a static page.
     */
    public function generateForStaticPage(string $pageType, string $pageLabel, string $locale): array
    {
        $langName = $this->getLangName($locale);

        $prompt = <<<PROMPT
You are an SEO expert for an online electronics store "{$this->getSiteName()}" ({$this->getSiteDomain()}) based in {$this->getSiteCountry()}.

Generate SEO metadata for the "{$pageLabel}" page in {$langName}.

Page type: {$pageType}
Page name: {$pageLabel}

Rules:
- Title: max 60 characters, describe this page clearly in {$langName}
- Description: max 160 characters, describe what users can find on this page, include store name in {$langName}
- Keywords: 5-7 comma-separated keywords relevant to this page in {$langName}
- All text must be in {$langName} language

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->callGemini($prompt);
    }

    /**
     * Call Gemini API and parse response.
     */
    private function callGemini(string $prompt): array
    {
        $model  = config('gemini.model', 'gemini-1.5-flash');
        $guzzle = new GuzzleClient([
            'timeout' => (int) config('gemini.request_timeout', 30),
            'verify'  => (bool) config('gemini.ssl_verify', true),
        ]);

        $client   = Gemini::factory()
            ->withApiKey(apiKey: config('gemini.api_key'))
            ->withHttpClient(client: $guzzle)
            ->make();

        $response = $client->generativeModel(model: $model)->generateContent($prompt);
        $text     = trim($response->text());

        // Strip markdown code blocks if present
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);

        $data = json_decode($text, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            Log::warning('Gemini SEO: Failed to parse JSON response', ['response' => $text]);
            throw new \RuntimeException('Gemini вернул невалидный JSON: ' . mb_substr($text, 0, 200));
        }

        return [
            'title'       => isset($data['title']) ? mb_substr((string)$data['title'], 0, 255) : null,
            'description' => isset($data['description']) ? mb_substr((string)$data['description'], 0, 500) : null,
            'keywords'    => isset($data['keywords']) ? mb_substr((string)$data['keywords'], 0, 500) : null,
        ];
    }

    private function getLangName(string $locale): string
    {
        return match ($locale) {
            'ru' => 'Russian',
            'ro' => 'Romanian',
            default => 'English',
        };
    }

    private function getSiteName(): string { return self::SITE_NAME; }
    private function getSiteDomain(): string { return self::SITE_DOMAIN; }
    private function getSiteCountry(): string { return self::SITE_COUNTRY; }
}
