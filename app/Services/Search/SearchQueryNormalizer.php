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
}

