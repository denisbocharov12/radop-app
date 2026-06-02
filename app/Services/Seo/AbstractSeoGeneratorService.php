<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Services\Seo\Contracts\SeoGeneratorContract;
use Illuminate\Support\Facades\Log;

/**
 * Shared SEO-prompt construction and response parsing.
 *
 * Provider-specific subclasses only need to implement {@see self::complete()},
 * which sends the prompt to the AI and returns the raw text answer.
 */
abstract class AbstractSeoGeneratorService implements SeoGeneratorContract
{
    protected const SITE_NAME    = 'Radop';
    protected const SITE_DOMAIN  = 'radop.md';
    protected const SITE_COUNTRY = 'Moldova';

    /**
     * Send a prompt to the underlying AI provider and return the raw text.
     */
    abstract protected function complete(string $prompt): string;

    /**
     * Business context injected into every prompt.
     * Radop — канцелярия, товары для офиса, школы и творчества.
     */
    protected function businessContext(string $langName): string
    {
        return <<<CTX
You are a senior SEO specialist with access to Google Search Console data, Google Trends, and keyword research tools (Ahrefs, SEMrush).

ABOUT THE COMPANY:
- Store: Radop (radop.md) — leading online stationery and office supplies store in Moldova
- Specialization: stationery, office supplies, school supplies, art & craft materials, paper products, writing instruments, organizers, filing & archiving, printer supplies, gifts and packaging
- Target market: Moldova (Chișinău and all regions), customers in Russian and Romanian
- Competitors: local Moldovan stationery shops and marketplaces
- USP: wide assortment, fast delivery across Moldova, competitive prices, official brands

SEO STRATEGY:
- Prioritize HIGH search volume, HIGH commercial intent keywords for Moldova market
- Use transactional search intent patterns (users ready to buy)
- Include geo-modifiers where relevant (Moldova, Chișinău, livrare Moldova)
- Based on real search behavior: users search for product name + "купить", "цена", "интернет магазин" (in Russian) or "cumpăra", "preț", "magazin online" (in Romanian)
- Title must have strong CTR: include brand/product + key benefit + store authority signal
- Description must have CTA + key selling point (price, delivery, assortment)
- Keywords: mix of head terms + long-tail, transactional intent, {$langName} language

All output text must be in {$langName} language.
CTX;
    }

    /**
     * Generate SEO for a product.
     */
    public function generateForProduct(array $context, string $locale): array
    {
        $langName = $this->getLangName($locale);
        $title    = $context['title'] ?? '';
        $category = $context['category'] ?? '';
        $brand    = $context['brand'] ?? '';
        $summary  = $context['summary'] ?? '';
        $bizCtx   = $this->businessContext($langName);

        $prompt = <<<PROMPT
{$bizCtx}

TASK: Generate SEO metadata for a PRODUCT page on radop.md.

Product name: {$title}
Category: {$category}
Brand: {$brand}
Description: {$summary}

SEO REQUIREMENTS:
- Title (max 60 chars): product name + brand if space allows + transactional modifier. High CTR pattern: "[Product Name] [Brand] – купить в Radop" or "[Product Name] — цена, доставка по Молдове". Do NOT pad with filler words.
- Description (max 160 chars): lead with top benefit or unique feature, include CTA ("Заказать онлайн", "Быстрая доставка по Молдове", "Лучшая цена"), mention Radop. Must entice click from search results.
- Keywords (6-10 keywords): exact product name, product name + brand, product name + "купить"/"cumpăra", product name + "цена"/"preț", product name + "Молдова"/"Moldova", category keywords, brand keywords. Comma-separated, no duplicates.

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->parse($this->complete($prompt));
    }

    /**
     * Generate SEO for a category.
     */
    public function generateForCategory(array $context, string $locale): array
    {
        $langName  = $this->getLangName($locale);
        $name      = $context['name'] ?? '';
        $parent    = $context['parent'] ?? '';
        $summary   = $context['summary'] ?? '';
        $parentStr = $parent ? "Parent category: {$parent}" : '';
        $bizCtx    = $this->businessContext($langName);

        $prompt = <<<PROMPT
{$bizCtx}

TASK: Generate SEO metadata for a CATEGORY page on radop.md.

Category name: {$name}
{$parentStr}
Category description: {$summary}

SEO REQUIREMENTS:
- Title (max 60 chars): category name + scope signal. Pattern: "[Category] – купить в Молдове | Radop" or "[Category] — широкий выбор, доставка". Focus on what shoppers search when browsing this category.
- Description (max 160 chars): describe assortment breadth + key benefit (price, brands, delivery). CTA: "Смотреть каталог", "Выбирайте из X наименований", "Заказать с доставкой по Молдове". Include store name Radop.
- Keywords (6-10): category name, category + "купить"/"cumpăra", category + "цены"/"prețuri", category + "интернет магазин"/"magazin online", category + "Молдова"/"Moldova", subcategory terms, popular brands in this category if known. Comma-separated.

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->parse($this->complete($prompt));
    }

    /**
     * Generate SEO for a brand.
     */
    public function generateForBrand(array $context, string $locale): array
    {
        $langName    = $this->getLangName($locale);
        $name        = $context['name'] ?? '';
        $description = $context['description'] ?? '';
        $bizCtx      = $this->businessContext($langName);

        $prompt = <<<PROMPT
{$bizCtx}

TASK: Generate SEO metadata for a BRAND page on radop.md.

Brand name: {$name}
Brand description: {$description}

SEO REQUIREMENTS:
- Title (max 60 chars): "[Brand] — канцелярия и товары для офиса | Radop" or "[Brand] купить в Молдове – Radop". Use your knowledge of this brand's positioning and what products it's known for.
- Description (max 160 chars): what this brand is known for (product types, quality, target audience), where to buy in Moldova, CTA. Use your knowledge of the brand from internet sources. Include Radop.
- Keywords (6-10): brand name, brand + product types (e.g. "Bic ручки", "Stabilo маркеры"), brand + "купить"/"cumpăra", brand + "Молдова"/"Moldova", brand + "цена"/"preț", brand + "официальный магазин". Use real popular search patterns for this brand. Comma-separated.

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->parse($this->complete($prompt));
    }

    /**
     * Generate SEO for a static page.
     */
    public function generateForStaticPage(string $pageType, string $pageLabel, string $locale): array
    {
        $langName = $this->getLangName($locale);
        $bizCtx   = $this->businessContext($langName);

        $prompt = <<<PROMPT
{$bizCtx}

TASK: Generate SEO metadata for a STATIC/INFORMATIONAL page on radop.md.

Page type identifier: {$pageType}
Page name: {$pageLabel}

SEO REQUIREMENTS:
- Title (max 60 chars): clear page purpose + store name. Example patterns: "Доставка по Молдове — Radop", "Контакты магазина Radop | Кишинёв", "Политика конфиденциальности | Radop". Must be descriptive and match user search intent for this type of page.
- Description (max 160 chars): what the user will find on this page, key info (working hours, delivery zones, return conditions, etc. — use your knowledge of what such pages contain), include Radop and Moldova context.
- Keywords (5-8): page-relevant terms users actually search (e.g. "доставка канцелярии Молдова", "контакты канцелярского магазина", "возврат товара интернет магазин Молдова"). Comma-separated.

Respond ONLY with a valid JSON object, no markdown, no extra text:
{"title":"...","description":"...","keywords":"..."}
PROMPT;

        return $this->parse($this->complete($prompt));
    }

    /**
     * Parse the AI text answer (tolerant to markdown fences) into the SEO shape.
     */
    protected function parse(string $text): array
    {
        $text = trim($text);

        // Strip markdown code blocks if present.
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', (string) $text);

        $data = json_decode((string) $text, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            Log::warning(static::class . ': Failed to parse JSON response', ['response' => $text]);
            throw new \RuntimeException($this->provider() . ' вернул невалидный JSON: ' . mb_substr((string) $text, 0, 200));
        }

        return [
            'title'       => isset($data['title']) ? mb_substr((string) $data['title'], 0, 255) : null,
            'description' => isset($data['description']) ? mb_substr((string) $data['description'], 0, 500) : null,
            'keywords'    => isset($data['keywords']) ? mb_substr((string) $data['keywords'], 0, 500) : null,
        ];
    }

    protected function getLangName(string $locale): string
    {
        return match ($locale) {
            'ru' => 'Russian',
            'ro' => 'Romanian',
            default => 'English',
        };
    }
}
