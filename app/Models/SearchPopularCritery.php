<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Search\SearchPopularCriteryManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * ТЗ 68: популярный поисковый запрос.
 *
 * Строка на запрос и язык: счётчик растёт сам, администратор может закрепить
 * нужный запрос наверху или убрать неудачный из выдачи.
 */
final class SearchPopularCritery extends Model
{
    protected $fillable = [
        'query',
        'locale',
        'hits',
        'results',
        'is_pinned',
        'is_hidden',
        'position',
        'last_searched_at',
    ];

    protected $casts = [
        'hits' => 'integer',
        'results' => 'integer',
        'is_pinned' => 'boolean',
        'is_hidden' => 'boolean',
        'position' => 'integer',
        'last_searched_at' => 'datetime',
    ];

    /*
     * Витрина держит список в кеше, поэтому правка из админки должна его
     * сбрасывать — иначе закреплённый запрос появится только через четверть
     * часа. Счётчик при поиске растёт мимо модели и кеш не трогает.
     */
    protected static function booted(): void
    {
        $forget = static function (self $critery): void {
            app(SearchPopularCriteryManager::class)->forget($critery->locale);
        };

        static::saved($forget);
        static::deleted($forget);
    }

    /** Витрине нужны только видимые запросы нужного языка, в порядке показа. */
    public function scopeVisible(Builder $query, string $locale): Builder
    {
        return $query
            ->where('locale', $locale)
            ->where('is_hidden', false)
            ->orderByDesc('is_pinned')
            ->orderBy('position')
            ->orderByDesc('hits');
    }
}
