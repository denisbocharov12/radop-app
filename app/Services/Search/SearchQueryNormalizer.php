<?php
declare(strict_types=1);

namespace App\Services\Search;

final class SearchQueryNormalizer
{
    /**
     * @param string $query
     * @return string
     */
    public function normalize(string $query): string
    {
        $query = mb_strtolower(trim($query));
        
        $query = preg_replace('/[-_\/\\\\]+/', ' ', $query);
        
        $query = preg_replace('/\s+/', ' ', $query);
        
        return trim($query);
    }

    /**
     * @param string $query
     * @return array<int, string>
     */
    public function extractWords(string $query): array
    {
        $normalized = $this->normalize($query);
        
        $words = explode(' ', $normalized);
        
        return array_filter($words, fn($word) => mb_strlen($word) > 0);
    }

    /**
     * @param string $word
     * @return string
     */
    public function stem(string $word): string
    {
        $word = mb_strtolower(trim($word));
        $length = mb_strlen($word);
        
        if ($length <= 3) {
            return $word;
        }
        
        if ($length >= 6) {
            return mb_substr($word, 0, -3);
        }
        
        if ($length >= 4) {
            return mb_substr($word, 0, -2);
        }
        
        return $word;
    }

    /**
     * @param array<int, string> $words
     * @return array<int, string>
     */
    public function stemWords(array $words): array
    {
        return array_unique(array_map(fn($word) => $this->stem($word), $words));
    }

    /**
     * @param string $query
     * @return array<int, string>
     */
    public function generateSearchVariants(string $query): array
    {
        $normalized = $this->normalize($query);
        
        $variants = [$normalized];
        
        $withoutSpaces = str_replace(' ', '', $normalized);
        if ($withoutSpaces !== $normalized) {
            $variants[] = $withoutSpaces;
        }
        
        $withDashes = str_replace(' ', '-', $normalized);
        if ($withDashes !== $normalized) {
            $variants[] = $withDashes;
        }
        
        $withUnderscores = str_replace(' ', '_', $normalized);
        if ($withUnderscores !== $normalized) {
            $variants[] = $withUnderscores;
        }
        
        return array_unique($variants);
    }

    /**
     * @param string $query
     * @return array<int, string>
     */
    public function extractArticles(string $query): array
    {
        $articles = [];
        
        if (preg_match_all('/\b(\d{3,7})\b/', $query, $matches)) {
            $articles = array_merge($articles, $matches[1]);
        }
        
        return array_unique($articles);
    }
}

