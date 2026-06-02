<?php

declare(strict_types=1);

namespace App\Services\Seo\Contracts;

/**
 * Contract for AI-backed SEO metadata generators.
 *
 * Each implementation talks to a different AI provider (Gemini, Claude, …)
 * but returns the same shape: ['title' => ?string, 'description' => ?string,
 * 'keywords' => ?string].
 */
interface SeoGeneratorContract
{
    public function generateForProduct(array $context, string $locale): array;

    public function generateForCategory(array $context, string $locale): array;

    public function generateForBrand(array $context, string $locale): array;

    public function generateForStaticPage(string $pageType, string $pageLabel, string $locale): array;

    /**
     * Machine key of the provider, e.g. "gemini" or "claude".
     */
    public function provider(): string;
}
