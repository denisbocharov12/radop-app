<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

/**
 * Locale-aware templated fallbacks for meta title and description used when
 * a `SeoMeta` row is missing or has empty fields. Each output is guaranteed
 * to mention the entity name so titles stay locally-unique.
 */
final class SeoFallbackGenerator
{
    private const BRAND_SUFFIX = 'Radop.md';

    public function homeTitle(string $locale): string
    {
        return match ($locale) {
            'ru' => 'Канцтовары и офисные принадлежности оптом и в розницу в Молдове | ' . self::BRAND_SUFFIX,
            default => 'Rechizite de birou și școlare en gros și cu amănuntul în Moldova | ' . self::BRAND_SUFFIX,
        };
    }

    public function homeDescription(string $locale): string
    {
        return match ($locale) {
            'ru' => 'Radop.md — канцелярские товары для офиса, школы и творчества. 30 лет на рынке Молдовы. Доставка по Кишинёву и стране. Оптовые и розничные цены.',
            default => 'Radop.md — rechizite de birou, școlare și creație. 30 de ani pe piața din Moldova. Livrare în Chișinău și în toată țara. Prețuri en gros și cu amănuntul.',
        };
    }

    public function categoryTitle(Category $category, string $locale): string
    {
        $name = $this->safeName($category->name);
        return match ($locale) {
            'ru' => "{$name} — купить в Молдове | " . self::BRAND_SUFFIX,
            default => "{$name} — cumpără în Moldova | " . self::BRAND_SUFFIX,
        };
    }

    public function categoryDescription(Category $category, string $locale): string
    {
        $name    = $this->safeName($category->name);
        $summary = strip_tags((string) $category->summary);
        if ($summary !== '') {
            // Use existing CMS summary when present; trim to 160.
            return $this->clip($summary, 160);
        }

        return match ($locale) {
            'ru' => "Купить {$name} в Молдове по выгодным ценам. Широкий ассортимент, доставка по Кишинёву и всей стране. Оптовые и розничные цены на Radop.md.",
            default => "Cumpără {$name} în Moldova la prețuri avantajoase. Asortiment larg, livrare în Chișinău și în toată țara. Prețuri en gros și cu amănuntul pe Radop.md.",
        };
    }

    public function brandTitle(Brand $brand, string $locale): string
    {
        $name = $this->safeName($brand->title ?? $brand->name ?? '');
        return match ($locale) {
            'ru' => "Продукция {$name} — официальный поставщик в Молдове | " . self::BRAND_SUFFIX,
            default => "Produse {$name} — distribuitor oficial în Moldova | " . self::BRAND_SUFFIX,
        };
    }

    public function brandDescription(Brand $brand, string $locale): string
    {
        $name = $this->safeName($brand->title ?? $brand->name ?? '');
        return match ($locale) {
            'ru' => "Каталог продукции {$name} в Молдове на Radop.md. Оригинальный товар, гарантия качества, доставка по Кишинёву и стране. Оптовые и розничные цены.",
            default => "Catalogul de produse {$name} în Moldova pe Radop.md. Produs original, garanție de calitate, livrare în Chișinău și în toată țara. En gros și cu amănuntul.",
        };
    }

    public function productTitle(Product $product, string $locale): string
    {
        $name  = $this->safeName($product->title ?? '');
        $brand = $this->safeName(optional($product->brand)->title ?? '');
        $sku   = (string) ($product->onec_id ?? '');

        $head = trim($name . ($brand !== '' ? ' ' . $brand : '') . ($sku !== '' ? ' ' . $sku : ''));
        return match ($locale) {
            'ru' => "{$head} — купить в Молдове | " . self::BRAND_SUFFIX,
            default => "{$head} — cumpără în Moldova | " . self::BRAND_SUFFIX,
        };
    }

    public function productDescription(Product $product, string $locale): string
    {
        $name = $this->safeName($product->title ?? '');
        $brand = $this->safeName(optional($product->brand)->title ?? '');
        $brandFragment = $brand !== ''
            ? (match ($locale) { 'ru' => " от {$brand}", default => " de la {$brand}" })
            : '';

        return match ($locale) {
            'ru' => $this->clip("Купить {$name}{$brandFragment} в Молдове на Radop.md. Доставка по Кишинёву и стране. Оптовые и розничные цены, гарантия качества.", 160),
            default => $this->clip("Cumpără {$name}{$brandFragment} în Moldova pe Radop.md. Livrare în Chișinău și în toată țara. Prețuri en gros și cu amănuntul, garanție.", 160),
        };
    }

    private function safeName(?string $raw): string
    {
        if ($raw === null) {
            return '';
        }
        $clean = trim(strip_tags($raw));
        return $clean;
    }

    private function clip(string $text, int $max): string
    {
        if (mb_strlen($text) <= $max) {
            return $text;
        }
        return rtrim(mb_substr($text, 0, $max - 1)) . '…';
    }
}
