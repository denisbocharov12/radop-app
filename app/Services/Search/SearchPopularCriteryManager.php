<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Models\SearchPopularCritery;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * ТЗ 68: учёт и выдача популярных поисковых запросов.
 *
 * Запрос записываем только тогда, когда он что-то нашёл: список популярного
 * должен вести к товарам, а не к пустым страницам. Сам список короткий и
 * меняется медленно, поэтому держим его в кеше.
 */
final class SearchPopularCriteryManager
{
    private const CACHE_PREFIX = 'search_popular_';

    private const CACHE_TTL = 900;

    /** Короче трёх букв запрос ничего не говорит, длиннее шестидесяти не читается. */
    private const MIN_LENGTH = 3;

    private const MAX_LENGTH = 60;

    public function record(string $query, string $locale, int $results): void
    {
        $normalized = $this->normalize($query);

        if ($normalized === null || $results < 1) {
            return;
        }

        $now = now();

        // Массовое обновление не поднимает событий модели — счётчик растёт на
        // каждом поиске, и сбрасывать из-за него кеш не нужно.
        $updated = SearchPopularCritery::query()
            ->where('query', $normalized)
            ->where('locale', $locale)
            ->update([
                'hits' => DB::raw('hits + 1'),
                'results' => $results,
                'last_searched_at' => $now,
                'updated_at' => $now,
            ]);

        if ($updated > 0) {
            return;
        }

        try {
            SearchPopularCritery::query()->create([
                'query' => $normalized,
                'locale' => $locale,
                'hits' => 1,
                'results' => $results,
                'last_searched_at' => $now,
            ]);
        } catch (QueryException) {
            // Тот же запрос успел создать другой посетитель — ничего страшного.
        }
    }

    /**
     * @return Collection<int, string>
     */
    public function top(string $locale, int $limit = 8): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . $locale . '_' . $limit,
            self::CACHE_TTL,
            static fn () => SearchPopularCritery::query()
                ->visible($locale)
                ->take($limit)
                ->pluck('query'),
        );
    }

    public function forget(string $locale): void
    {
        foreach ([4, 6, 8, 10, 12] as $limit) {
            Cache::forget(self::CACHE_PREFIX . $locale . '_' . $limit);
        }
    }

    /** Приводим запрос к одному виду, иначе «Hartie A4» и «hartie  a4» разойдутся. */
    private function normalize(string $query): ?string
    {
        $value = trim(preg_replace('~\s+~u', ' ', $query) ?? '');

        if ($value === '' || mb_strlen($value) < self::MIN_LENGTH) {
            return null;
        }

        // Коды, артикулы и штрихкоды — это разовый поиск конкретной позиции,
        // в подборке популярного им делать нечего.
        if (ctype_digit($value)) {
            return null;
        }

        return mb_strtolower(mb_substr($value, 0, self::MAX_LENGTH));
    }
}
